This exercise was asked by a contractor, in order to obtain the job.
===

###Write up a class called largeinteger that will provide the following methods:

- __construct($integer_value)  // this is the value that the object instantiation represents.
- get_value()  // returns the integer value set to the object
- equal_to(largeinteger $comparsion_object)
- not_equal_to(largeinteger $comparsion_object)
- greater_than(largeinteger $comparsion_object)
- less_than(largeinteger $comparsion_object)
- greater_or_equal_than(largeinteger $comparsion_object)
- less_or_equal_than(largeinteger $comparsion_object)
- add(largeinteger $second_object) // this returns a new instance of largeinteger

###RULES:
- The comparison operations will return a true or false value, based on the test conducted between the current object and the passed object.
- The class should only deal with unsigned ints. Throw an exception if it's < 0.
- 0 with any kind of sign should be treated as 0.
- The class needs to be able to support really large ints, like 12323543598732149872958714082798523523489723897423897423897429874987239847 for example. So it needs a way to handle integers that don't fit into the int core data structure.
- Create a unit test that tests out the public interfaces and tests out a variety of sample data
- The add operation shouldn't use a predefined module/function (like the BC calculator methods), but instead please write this method from scratch. It'll add the value of the current object and the value of the second object and then put their sum into a new object and return that.
- Ensure that your class will work with PHP 5.3.