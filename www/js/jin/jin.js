"use strict";
/**
 * @doc
 * Предмет - стек с переменными
 *  по setState интерпретирует код в список хэшей имя переменной - тип
 *
 * Наблюдатели - три отображения
*/
(function() {
    $(init);
    function init() {
        /** @classes*/
        //чтобы гарантировать доступность extend на момент определения кода классов
        //использую вызов create* функций
        var Variables = createVariables(), //Subject
            CodeView = createCodeView(),   //Observer && Widget
            StackView = createStackView(CodeView), //Observer
            JsView    = createJsView(CodeView),    //Observer
            CppView = createCppView(CodeView);     //Observer
        /** @variables*/

        //Observer
        var subject = new Variables(),
            cppView = new CppView(subject),
            stackView = new StackView(subject),
            jsView = new JsView(subject);
        subject.attach(jsView);
        subject.attach(cppView);
        subject.attach(stackView);

        //input
        $('#js-input').keydown(function(evt){
            subject.setCode(evt.target.value);
        });
    }
})()
