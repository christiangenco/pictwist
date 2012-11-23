puts '<?xml version="1.0" ?>'
puts '<response>'
puts '<photos>'

50.times do |i|
  puts "<photo name='Example picture #{i}' src='http://lorempixel.com/#{500+rand(500)}/#{500+rand(500)}/' thumb='http://lorempixel.com/100/100/'>"
  puts "<comments>"
  c = rand(10)
  rand(10).times do |j|
    puts "<comment text='Example comment #{i}.#{j}' username='example_username_#{rand(20)}' date='2012-11-#{10+j+c} 12:#{10+j+rand(5)}:#{10+rand(50)}' />"
  end
  puts "</comments>"
  puts "</photo>"
end

puts '</photos>'
puts '</response>'