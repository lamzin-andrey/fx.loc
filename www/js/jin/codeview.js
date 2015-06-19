//чтобы гарантировать доступность extend на момент определения кода классов
//использую вызов create* функций
function createCodeView() {
    function C(subject, divId) {
        Observer.apply(this, arguments);
        this.div = $('#' + divId);
        this.functionTpl = '{{ftype}} {{fname}}() {\n<br>{{fbody}}}';
        this.instrTpl = '\t&nbsp;&nbsp;&nbsp;&nbsp;{{vtype}} {{vname}} = {{value}};';
        this.code = [];
    }
    extend(C, Observer);
    /**
     * @param {Subject} subject
    */
    C.prototype.update = function(subject) {
        var data = subject.data, varname, fName;
        this.clearArea();
        this.code = [];
        for (varname in data) {
            fName = data[varname].F;
            this.addInstruction(varname, data[varname]);
        }
        this.draw(fName);
    }
    /**
     * @desc Чистит область вывода
    */
    C.prototype.clearArea = function() {
        this.div.html();
    }
    /**
     * @desc Добавляет инструкцию в вывод
     */
    C.prototype.addInstruction = function(varname, data) {
        //this.code.push(
        //    //...
        //);
    }
    /**
     * @desc Отрисовка кода
     */
    C.prototype.draw = function(fName) {
        //this.div.html();
    }
    return C;
}