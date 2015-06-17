//чтобы гарантировать доступность extend на момент определения кода классов
//использую вызов create* функций
function createStackView(CodeView) {
    function C(subject) {
        this.initCodeView(subject, 'stackview');
        this.instrTpl = '<div class="left">{{vtype}}</div><div class="left">{{vname}}</div><div class="left">{{value}}</div><div class="left">{{fname}}</div><div class="clearfix"></div>';
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
                    .replace('{{fname}}', data.F)
            )
        );
    }
    /**
     * @desc Отрисовка кода
     */
    C.prototype.draw = function(fName) {
        var body = this.code.join('\n'),
            head = this.instrTpl.replace('{{vtype}}', 'Тип').replace('{{vname}}', 'Имя')
                .replace('{{value}}', 'Значение')
                .replace('{{fname}}', 'Функция'),
            s = '<div class="stackviewhead">' + head  + '</div>' + body;

        this.div.html(s);
    }
    return C;
}