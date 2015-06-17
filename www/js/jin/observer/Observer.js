/**
 *Паттерн Наблюдатель.
 *Класс Абстрактный Наблюдатель
 * update()
   
 *Класс Абстрактный Предмет Наблюдения
 * attach()
 * detach()
 * notify()
 * 
 * _observers
 *
 *Класс Конкретный  Наблюдатель
 *Класс Конкретный Предмет Наблюдения
*/
/** @class Observer Базовый наблюдатель */
function Observer(subject) {
  this.initObserver(subject);
}
Observer.prototype.initObserver = function(subject) {
  this._subject = subject;
}
Observer.prototype.update = function() {}

/** @class Subject Базовый предмет наблюдения */
function Subject() {
  //this.initSubject();
}
Subject.prototype._observers = [];
/*Subject.prototype.initSubject = function() {
  this._observers = [];
}*/
Subject.prototype.attach = function(observer) {
  this._observers.push(observer);
}
Subject.prototype.detach = function(observer) {
  for (var i = 0; i < this._observers.length; i++) {
    if (this._observers[i] == observer) {
      this.observers.splice(i, 1);
      return true;
    }
  }
  return false;
}
  
Subject.prototype.notify = function() {
  //console.log( this._observers )
  for (var i = 0; i < this._observers.length; i++) {
    this._observers[i].update(this);
  }
}
