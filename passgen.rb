#!/usr/bin/ruby -w

# Written by Joe Martin <joe@desertflood.com>
# 2012-01-31
# Version 0.1

require 'RandomOrgClient'
require 'rubygems'
require 'json'

words = JSON.parse(File.open("diceware.wordlist.json").read)

###############################################################################
#Example Usage
#
# Initialize the client.  We need to pass in our email address so Dr. Haahr
# can "drop you a line if your client is causing trouble".
rc = RandomOrgClient.new("joe@desertflood.com")

# Find and print our current quota.  If it doesnt work, we need to know why.
if quota = rc.get_quota
	puts "Our quota is: #{quota}\n\n"
else
	puts "An Error has occured!"
	puts "--"
	rc.get_errors.each do |err|
		puts "HTTP Status: #{err['code']}"
		puts "Body: #{err['error']}"
	end
	puts "--"
	rc.clear_errors
end

number = 0
if ARGV.count == 1
  number = ARGV[0].to_i
end
if number == 0
  number = 5
end

# Get a number in the default range of -1000000000 to 1000000000
if rc.is_available?
	if input = rc.get_random_integer((number*5),1,6,5) # 5 integers, from 1-6, in 5 columns
    for line in input do
      line = line.split.join
      print words[line]+" "
    end
    puts ""
    # all_input = input.split.join
		# puts "Default random int: #{r_i.to_i}\\n\\n"
	else
		puts "An Error has occured!"
		puts "--"
		rc.get_errors.each do |err|
			puts "HTTP Status: #{err['code']}"
			puts "Body: #{err['error']}"
		end
		puts "--"
	end
else
	puts "Random.org is unavailable to you.  Check your quota and that the site is up."
end

