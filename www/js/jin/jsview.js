//чтобы гарантировать доступность extend на момент определения кода классов
//использую вызов create* функций
function createJsView(CodeView) {
    function C(subject) {
        this.initCodeView(subject, 'jsview');
    }
    extend(C, CodeView);
    /**
     * @desc Добавляет инструкцию в вывод
     */
    C.prototype.addInstruction = function(varname, data) {
        var tpl = '<div>{S}</div>', body;
        this.code.push(
            tpl.replace('{S}',
                this.instrTpl.replace('{{vtype}}', 'var').replace('{{vname}}', varname)
                    .replace('{{value}}', data.value)
            )
        );
    }
    /**
     * @desc Отрисовка кода
     */
    C.prototype.draw = function(fName) {
        var body = this.code.join('\n'),
            s;
        if (fName == 'main') {
            s = body.replace(/\t&nbsp;&nbsp;&nbsp;&nbsp;/gi, '');
        } else {
            this.functionTpl.replace('{{ftype}}', 'function');
            s = s.replace('{{fname}}', fName).replace('{{fbody}}', body);
        }
        this.div.html(s);
    }
    return C;
}