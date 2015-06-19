//чтобы гарантировать доступность extend на момент определения кода классов
//использую вызов create* функций
function createCppView(CodeView) {
    function C(subject) {
        CodeView.apply(this, [subject, 'cppview']);
    }
    extend(C, CodeView);
    /**
     * @desc Добавляет инструкцию в вывод
     */
    C.prototype.addInstruction = function(varname, data) {
        var tpl = '<div>{S}</div>', body;
        this.code.push(
            tpl.replace('{S}',
                        this.instrTpl.replace('{{vtype}}', data.type).replace('{{vname}}', varname)
                                     .replace('{{value}}', data.value)
            )
        );
    }
    /**
     * @desc Отрисовка кода
     */
    C.prototype.draw = function(fName) {
        var body = this.code.join('\n'),
            s = this.functionTpl.replace('{{ftype}}', 'void');//TODO подумать как получать тип функции
        s = s.replace('{{fname}}', fName).replace('{{fbody}}', body);
        this.div.html(s);
    }
    return C;
}