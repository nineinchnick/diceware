diceware -- A password, passphrase, and pin generator, using the diceware method
====================================

## DESCRIPTION

Arnold Reinhold proposed the [Diceware](http://world.std.com/~reinhold/diceware.html) method of generating passphrases: start with a dictionary of 7776 common words and use dice rolls to pick words from that dictionary, to form the phrase.

Using actual dice is preferred, for true security and true randomness. However, I find that tedious and am not quite paranoid enough to go through the effort of doing so. I'm creating these programs, to use the method while taking the grunt work out of the method.

I'm using the [Diceware 8k list](http://world.std.com/%7Ereinhold/dicewarefaq.html#computer), which is optimized for computer selection of words. I'm using [RANDOM.ORG](http://www.random.org) to generate random numbers and simulate dice rolls.

## SHOULD YOU USE THIS?

You probably shouldn't use this code to generate actual pass phrases. How much do you trust the author of a public Github code repository? How much do you trust the randomness of RANDOM.ORG? How much do you trust the connection between my server and RANDOM.ORG, to ensure that someone else isn't substituting numbers for the dice rolls? How much do you trust me, to not track the generated numbers and passwords? How much do you trust [Joyent](http://www.joyent.com) (my hosting provider) or all of the networks located between me and you?

With that much implied trust, you probably shouldn't trust the results of these scripts. But you can if you want.

## INSTALLATION

The legacy ruby client requires only a base ruby installation. The legacy PHP client requires at least PHP 5.3 and a webserver capable of running PHP.

## RUNNING

passgen.rb -- Takes one parameter, of the number of words to include in the passphrase. If not supplied, it defaults to five words.

pingen.php -- Allows you to specify the number of PINs to generate and the number of numbers in each PIN.

## BASIC METHOD

1. Pick a number of words to generate
2. Generate 5 random numbers for each desired word
3. Arrange the numbers in groups of 5 and look up that entry in the word list
4. Insert a random character after a random character in your pass phrase using four additional dice rolls.
    1. Roll to pick the word
    2. Follow the "USING DICE TO PICK A RANDOM CHARACTER IN A WORD" method, to determine where to place the random character.
    4. Roll twice more, to pick from the following table. In array notation, this looks like table\[dice1\]\[dice2\].
    5. Add the character to the given position in the given word. 

    [
    ["~","&","+",":","?","4"],
    ["!","*","[",";","/","5"],
    ["#","(","]","\"","0","6"],
    ["$",")","\\","'","1","7"],
    ["%","-","{","<","2","8"],
    ["^","=","}",">","3","9"],
    ]

## GENERATING SPECIAL CHARACTERS

1. Roll two numbers
2. Use the numbers to pick a special character from the array below
3. If you get a number and don't want it, roll again

    [
    ["!","@","#","$","%","^"],
    ["&","*","(",")","-","="],
    ["+","[","]","{","}","\\"],
    ["|","`",";",":","'","\""],
    ["<",">","/","?",".",","],
    ["~","_","3","5","7","9"]
    ]

In array notation, this looks like table\[dice1\]\[dice2\].

## USING DICE TO PICK A RANDOM CHARACTER IN A WORD

1. Pick the column in the table below that corresponds to the number of characters in the chosen word.
2. Then roll one die and look up the number you get on the left hand side of the table.
3. Insert the random character after the selected letter.
4. Zero means put the random character at the beginning of the word.
5. Roll the dice again whenever you get a *.

    [
    ["1","1","1","1","1"],
    ["2","2","2","2","2"],
    ["0","3","3","3","3"],
    ["1","0","4","4","4"],
    ["2","*","0","5","5"],
    ["0","*","*","0","6"]
    ]

In array notation, this looks like table\[numChars\]\[dice\].

## [Random Character Strings](http://world.std.com/%7Ereinhold/dicewarefaq.html#randomstrings)

## [Random Decimal Numbers](http://world.std.com/%7Ereinhold/dicewarefaq.html#decimal)

You really don't need the table to use this method: Just roll a die until you get a number that isn't 6. Then roll the die again. If the second result is even, add 5 to the first number you got. Treat a ten as a zero. That's it.

## CONTRIBUTE

If you'd like to hack on diceware, start by forking my repo on GitHub:

http://github.com/jmartindf/diceware
