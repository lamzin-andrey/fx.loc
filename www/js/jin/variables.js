//чтобы гарантировать доступность extend на момент определения кода классов
//использую вызов create* функций
function createVariables() {
    function C() {
        this.data = {};
    }
    extend(C, Subject);
    //TODO interpretator
    C.prototype.setCode = function(s) {
        this.data['var1'] = {type: 'int', value: 10, F: 'main'};
        this.notify();
    }
    return C;
}