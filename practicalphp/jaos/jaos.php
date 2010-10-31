<?php 
/*
Tokens
In order to create the lexer, we need some token types to match
we need to have a number token type, a variable type, an assignment type,
a print type, a string type, a semi-colon type, and a plus type
*/

define("JAOS_NUMBER", 0);
define("JAOS_VARIABLE", 1);
define("JAOS_ASSIGNEQUALS", 2);
define("JAOS_PRINT", 3);
define("JAOS_STRING", 4);
define("JAOS_SEMICOLON", 5);
define("JAOS_PLUS", 6);
define("JAOS_MULTIPLY", 7);

//what is a token??
define("IS_OPERATOR", 0);
define("IS_OPERAND", 1);

/* variable namings A-Z, a-z, _ */

$characters = array_merge(range('a', 'z'), range('A', 'Z'));
$characters[] = "_";

//to store variables
$variables = array();

/*
We will be storing the last value read in by gettoken() in the $lasttoken variable, 
which will be global across the whole script. With these in place we have enough to implement the gettoken() 
function.
tokenizing - lexical analyser/lexer
*/


function gettoken() {
    GLOBAL $script, $characters, $lasttoken;
    $c = 0;

    // delete whitespace
    while (($c = fgetc($script)) == ' ' || $c == "\t" || $c == "\n" || $c == "\r");
	

    // exit if EOF is reached
    if (feof($script)) exit;

    // match numbers
    if (is_numeric($c)) {
        $nextchar = fgetc($script);

        while(is_numeric($nextchar)) {
            $c .= $nextchar;
            $nextchar = fgetc($script);
        }

        // the last character read was not a number, put it back
        fseek($script, -1, SEEK_CUR);
        $lasttoken = $c;
        return JAOS_NUMBER;
    }

    if ($c == "=") {
        return JAOS_ASSIGNEQUALS;
    }

    if ($c == "+") {
        return JAOS_PLUS;
    }

    if ($c == "*") {
        return JAOS_MULTIPLY;
    }

    if ($c == ";") {
        return JAOS_SEMICOLON;
    }

    if ($c == "\"") {
        $nextchar = fgetc($script);

        while($nextchar != "\"") {
            if ($nextchar == "\n") {
                die("Fatal error: Unterminated string\n");
            }
            $c .= $nextchar;
            $nextchar = fgetc($script);
        }

        // note, we don't put the last character back here as it is the closing double-quote
        // trim off the double quote at the beginning
        $lasttoken = trim($c, "\" \t\n\r");
        return JAOS_STRING;
    }

    if (is_string($c)) {
        $nextchar = fgetc($script);
        while($nextchar != "\n" && in_array($nextchar, $characters)) {
            $c .= $nextchar;
            $nextchar = fgetc($script);
        }

        // last character was not a letter, put it back
        fseek($script, -1, SEEK_CUR);
        $lasttoken = trim($c);

        // is this a print statement? If so, it's special
        switch($lasttoken) {
            case "print":
                return JAOS_PRINT;
                break;
            default:
                return JAOS_VARIABLE;
        }
    }
}


/* token class 
The two "obvious" properties of each token are the token it actually is, 
e.g. JAOS_NUMBER or JAOS_ASSIGNEQUALS, and also its value, e.g. 29 or "abcdefg". 

Operators do not have a value, as their entire meaning is encapsulated inside their token definition.
With this simple definition of a token we have enough information to create a class, token, that will do all we need of it:
*/

class token {
    public $type;
    public $token;
    public $val;

    public function __construct($type, $token, $val) {
        $this->type = $type;
        $this->token = $token;
        $this->val = $val;
    }
}



/* -- The Parser --

the second stage of analysis is syntax analysis, 
which means we need to verify that the tokens have come into us in the right order. 
This is actually fairly easy to do if you have the parser generator Bison to hand, 
but PHP's equivalent (phpJay) is not very well developed right now. 

So, instead we're going to call gettoken() repeatedly until we get a semi-colon, at which point we will execute the line.

Converting to Reverse Polish Notation (RPN) is quite straightforward, 
but it requires a little thinking. 
The easiest way to handle the conversion is to totally ignore operator precedence, 
so this is the route we will take for now - this will be added later.

 In order to convert to RPN, we need to have two arrays in place: one for the expression, and one for the operators.

 As the tokens are parsed, all the non-operator tokens are put directly into the expression array as they are sent in,
 and all the operators are put into the operator array. 
 
 Once the end of the statement is reached, 
 all the operators are put onto the end of the expression array in reverse order.
*/

function main() {
    GLOBAL $lasttoken;

    while(1) {
        $stack = array();
        $operators = array();

        do {
            $token = gettoken();

            switch($token) {
                case JAOS_NUMBER:
                case JAOS_VARIABLE:
                case JAOS_STRING:
                    $stack[] = new token(IS_OPERAND, $token, $lasttoken);
                    break;
                default:
                    /*if ($token != JAOS_SEMICOLON) {
                        $operators[] = new token(IS_OPERATOR, $token, NULL);
                    }*/
					//considering operator precedence
					if ($token != JAOS_SEMICOLON) {
						while (count($operators) && $precedence[$operators[count($operators) - 1]->token] > $precedence[$token]) {
							$higher_op = array_pop($operators);
							array_push($stack, $higher_op);
						}
						$operators[] = new token(IS_OPERATOR, $token, NULL);
					}
            }
        } while ($token != JAOS_SEMICOLON);

        // move operators to stack
        while (count($operators)) array_push($stack, array_pop($operators));
		//So the whole loop translates to, "while there are still operators, add to the end of the stack the end of the operators".
		
        // execute line!
		//Converting to Reverse Polish Notation (RPN
		//At this point we have our full RPN stack, and need to execute it
		//This is done through another function, cleverly called execute(), which takes a reference to the stack to execute.
        execute($stack);
    }
}


/*
-- The Output --
*/

function execute(&$stack) {
    GLOBAL $variables;
    $operator = array_pop($stack);

    if ($stack[count($stack) - 1]->type == IS_OPERATOR) {
        //"call execute(), and use as your other operator whatever it returns"
		$right = execute($stack);
    } else {
        $right = array_pop($stack);
    }

    if (count($stack)) {
        if ($stack[count($stack) - 1]->type == IS_OPERATOR) {
            $left = execute($stack);
		}
         else {
            $left = array_pop($stack);
        }
    }
	/*
	 The switch($operator->token) line is where it decides what action to take based upon the operator, 
	 so if the operator was JAOS_ASSIGNEQUALS it performs an assign. 
	 The $variables array is designed to have variable names as its keys and variables values as its values, 
	 which is why it's $variables[$left->val]. 
	 The call to getval() is there so that if we say "a = b", a won't be set to "b". 
	 Instead, the value of b will be looked up and assigned to a, thanks to getval(). 
	 Printing is almost exactly the same - retrieve the value of the token, and print it out.
	*/
	
	/*
	Both JAOS_PLUS and JAOS_MULTIPLY work in the same way - 
	they both take the values of their operands (using getval() again), 
	run it through an add or a multiply respectively, 
	then return the value inside a new token. This is where the recursiveness comes in.
	*/
    switch($operator->token) {
        case JAOS_ASSIGNEQUALS:
            $variables[$left->val] = getval($right);
            break;
        case JAOS_PLUS:
            return new token(IS_OPERAND, JAOS_NUMBER, getval($left) + getval($right));
        case JAOS_MULTIPLY:
            return new token(IS_OPERAND, JAOS_NUMBER, getval($left) * getval($right));
        case JAOS_PRINT:
            print getval($right);
            print "\n";
    }
}

/*-- get value of the expression --*/
function getval($token) {
    GLOBAL $variables;

    if ($token->token == JAOS_VARIABLE) {
        return $variables[$token->val];
    } else {
        return $token->val;
    }
}

function cleanup() {
        GLOBAL $script;
        fclose($script);
}

/*---- finally Calling the main() function  --- */
$sourcefile = $argv[1];
if ($sourcefile == "?" || $sourcefile == "help"){
	showhelp(0);
}
else if($sourcefile !=""){
	if (file_exists($sourcefile)){
		$ext = pathinfo($sourcefile, PATHINFO_EXTENSION);
		if($ext == "jos"){					
			$script = fopen($sourcefile, "r");
			//shutdown function just to make sure and close the file handle before the script terminates
			register_shutdown_function("cleanup");
			main();
		}else showhelp(3);
	}else showhelp(2);
}else showhelp(1);


/*--command line help file---*/

function showhelp($flag){
	print "\n";
	switch($flag){
		case 0:
			print "jaos version 67.4.3\n\n";
			print "Syntax:\n";
			print "----------------\n";
			print "compile\t: jaos source.jos\n\n";			
			print "help\t: jaos ?\n";			
			print "    \t: jaos help\n";						
			print "-----------------\n";
			break;
		case 1:
			print "Please provide a source file";
			break;
		case 2:
			print "File doesn't exists";		
			break;
		case 3:
			print "Invalid source file, provide jos file to compile";		
			break;
		default:
			print "thanks for using it";
	}
print "\n";	
}