"use strict"
function extend(Child, Parent) {
	/*
	не позволяет использовать
	ParentConstructor.apply(this, arguments);

	var F = function(){};
	F.prototype = Parent.prototype;
	Child.prototype = new F();
	Child.prototype.constructor = Child;
	Child.superclass = Parent.prototype;

	*/
	/*
 		Позволяет использовать
	 	ParentConstructor.apply(this, arguments);
 	*/
	Child.prototype = new Parent();
	Child.prototype.constructor = Child;
	Child.superclass = Parent.prototype;
}