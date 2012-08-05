###############################################################################
# A Random.org Client for Ruby.
#
# Author:: William Knechtel <bill@threebit.com>
# Copyright:: Copyright (c) 2011 William Knechtel
# License: Distributes under the same terms as Ruby
#
require 'net/http'

class RandomOrgClient
	
	# Initialize with an email address.  The email address is set as the 
	# User-Agent, so that Dr. Haahr (The Author and Operator of Random.org)
	# Can let you know if your client is misbehaving.
	def initialize(email_address)
		@@email = email_address
		self.clear_errors
		@@http = Net::HTTP.new("www.random.org", 80)
	end
	
	# Clear Errors is used to clean our the class variable errors array. 
	# Errors received from random.org are stored as an array in case you 
	# are using multiple calls to accomplish something, and the errors stack 
	# up.  
	def clear_errors
		@@errors = []
		return true
	end
	
	# Return the class variable errors array.  If any of your methods return
	# nil, it's a good idea to look at this variable to see why.
	def get_errors
		return @@errors
	end
	
	# Return your current random bit quota.  As of the writing of this 
	# documentation You get 1 millions bits per IP Address to start with, then a 
	# 200,000 bits per day "top off". Use your bits wisely.
	def get_quota
		quota_request = Net::HTTP::Get.new("/quota/?format=plain", {'User-Agent' => @@email})
		quota_response = @@http.request(quota_request)
		if quota_response.code == "200" and quota_response.body.to_i > 0
			return quota_response.body.to_i
		else
			if quota_response.code == "200"
				@@errors << {"code" => quota_response.code, "error" => "Your Quota is Exhausted. Quota = #{quota_response.body.to_i}"}
			else
				@@errors << {"code" => quota_response.code, "error" => quota_response.body}
			end
			return nil
		end
	end
	
	# Returns a boolean telling you if the server could be reached, is
	# functional, and you have random bits available to you.  You should use
	# this at the beginning of each random bit gathering session.
	def is_available?
		quota = self.get_quota
		if quota and quota > 0
			return true
		else
			return false
		end
	end
	
	# Return a random integer.  By default, it will return a single integer 
	# between -1000000000 and 1000000000. All random.org parameters are supported, 
	# see http://www.random.org/clients/http/ for documentation on these
	# parameters. This function will return the data as retrieved from random.org, 
	# which means a string representing the integers you've requested.  Be sure to 
	# cast them to an integer if you need it in that format, and do any appropriate
	# parsing if you've requested more than one number formatted in columns or
	# as xhtml.
	def get_random_integer(num = 1, min = -1000000000, max = 1000000000, col = 1, base = 10, format = "plain", rnd = "new")
		
		request_string = "/integers/?"
		request_string += "num=#{num.to_s}"
		request_string += "&min=#{min.to_s}"
		request_string += "&max=#{max.to_s}"
		request_string += "&col=#{col.to_s}"
		request_string += "&base=#{base.to_s}"
		request_string += "&format=#{format}"
		request_string += "&rnd=#{rnd}"
		
		integer_request = Net::HTTP::Get.new(request_string, {'User-Agent' => @@email})
		integer_response = @@http.request(integer_request)
		if integer_response.code == "200"
			if integer_response.body.match("Error:")
				@@errors << {"code" => integer_response.code, "error" => integer_response.body}
				return nil
			else
				return integer_response.body
			end
		else
			@@errors << {"code" => integer_response.code, "error" => integer_response.body}
			return nil
		end
	end
	
	# Return every integer between min and max in a random sequence. While you 
	# can use any set of integers between -1000000000 and 1000000000, the set
	# cannot contain more than 10,000 digits.  All random.org parameters are 
	# supported, see http://www.random.org/clients/http/ for documentation on 
	# these parameters. This function will return the data as retrieved from 
	# random.org, which means a string representing the integers you've 
	# requested.  Be sure to cast them to an integer if you need it in that 
	# format, and do any appropriate parsing if you've requested more than one 
	# number formatted in columns or as xhtml.
	def get_random_sequence(min = 1, max = 10000, col = 1, format = "plain", rnd = "new")
		
		request_string = "/sequences/?"
		request_string += "min=#{min.to_s}"
		request_string += "&max=#{max.to_s}"
		request_string += "&col=#{col.to_s}"
		request_string += "&format=#{format}"
		request_string += "&rnd=#{rnd}"
		
		sequence_request = Net::HTTP::Get.new(request_string, {'User-Agent' => @@email})
		sequence_response = @@http.request(sequence_request)
		if sequence_response.code == "200"
			if sequence_response.body.match("Error:")
				@@errors << {"code" => sequence_response.code, "error" => sequence_response.body}
				return nil
			else
				return sequence_response.body
			end
		else
			@@errors << {"code" => sequence_response.code, "error" => sequence_response.body}
			return nil
		end
	end
	
	# Return a random string of characters.  You can return up to 10,000 random 
	# strings, and each string can be up to 20 characters long.  The full set of
	# random.org parameters are supported, see http://www.random.org/clients/http/
	# for documentation on these parameters. This function will return the data 
	# as retrieved from random.org, which means if you've requested the data to 
	# be retrieved using columns or xhtml, you'll need to parse that out yourself.
	def get_random_string(num = 1, len = 20, digits = "on", upper_alpha = "on", lower_alpha = "on", unique = "on", format = "plain", rnd = "new")
		request_string = "/strings/?"
		request_string += "num=#{num.to_s}"
		request_string += "&len=#{len.to_s}"
		request_string += "&upperalpha=#{upper_alpha}"
		request_string += "&loweralpha=#{lower_alpha}"
		request_string += "&unique=#{unique}"
		request_string += "&format=#{format}"
		request_string += "&rnd=#{rnd}"
		
		string_request = Net::HTTP::Get.new(request_string, {'User-Agent' => @@email})
		string_response = @@http.request(string_request)
		if string_response.code == "200"
			if string_response.body.match("Error:")
				@@errors << {"code" => string_response.code, "error" => string_response.body}
				return nil
			else
				return string_response.body
			end
		else
			@@errors << {"code" => string_response.code, "error" => string_response.body}
			return nil
		end
	end
end