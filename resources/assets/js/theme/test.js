export default function submit(action, method, values) {
    if(action === false) return;
    var form = $('<form/>', {
        action: action,
        method: method
    });

    // add csrf token
    form.append($('<input/>', {
        type: 'hidden',
        name: '_token',
        value: $('meta[name="csrf-token"]').attr('content')
    }));

    $.each(values, function() {
        form.append($('<input/>', {
            type: 'hidden',
            name: this.name,
            value: this.value
        }));
    });
    form.appendTo('body').submit();
}

export function new1() {
    return "hello";
}


// export function create_submit_form() {
//     return "hello";
// }