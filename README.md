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

## CONTRIBUTE

If you'd like to hack on diceware, start by forking my repo on GitHub:

http://github.com/jmartindf/diceware
