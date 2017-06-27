var Lang = {
	'Incorrect_email' : 'Некорректный email',
	'Field_' : 'Поле ',
	'Unable_remove_product_from_cart' : 'Невозможно удалить товар из корзины',
	'_required__for_fill' : ' обязательно для заполнения'
};
function __(s) {
	if (Lang[s]) {
		return Lang[s];
	}
	return s;
}
