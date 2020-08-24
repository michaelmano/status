import Q from 'qoob';

const module = function module() {
    const select_inputs = Q.find('select');
    Q.each(select_inputs, select => {
        checkValues(select);
        Q.on(select, 'change', () => checkValues(select));
    });
}

const checkValues = function checkValues(select) {
    if (Q.val(select) == '' || Q.val(select) == null) {
        Q.removeClass(select, 'has-value');
    } else {
        Q.addClass(select, 'has-value');
    }
}

export default module;