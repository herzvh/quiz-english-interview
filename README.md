** Description **
In this refactoring, 
I try to use SRP (Single Responsability Principle) for class and methods.
I refactor the controller to a thin controller and fat model, so that I created two class model (Day, Meal).
I refactor the validator class out of the controller, as you can see on DateRequest class.
I also try to apply DRY principle, i.e refactor all reusable method to a private method on controller.
Finally, I use IoC on controller instead of creating an instance directly.


