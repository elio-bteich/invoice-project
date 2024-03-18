// adding a row and its columns with the right design

$(function (){
    $('#invoice-date').datepicker({
        dateFormat: 'dd/mm/yy'
    });
});


$('.add-item-btn').click(function () {
    let row = $('.table-wrapper tbody')[0].insertRow(-1)
    $(row).addClass('item-row')
    row.insertCell(0).innerHTML = '<button class="btn btn-danger w-50" style="font-size: 10px"><i class="fas fa-trash-alt"></i></button>'
    $(row).children('td:first').css('text-align', 'center')
    row.insertCell(1).innerHTML = '<input type="text" name="unit-code[]" class="text-center unit-code" required/>'
    row.insertCell(2).innerHTML = '<input type="number" name="unit-quantity[]" value="1" class="text-center unit-quantity" required>';
    row.insertCell(3).innerHTML = '<input type="text" name="unit-description[]" required><div id="items-list" style="display: none"></div>';
    row.insertCell(4).innerHTML = '<input type="text" name="unit-price[]" class="unit-price" required>';
    let col4 = row.insertCell(5).innerHTML = '<input type="text" name="total-price[]" class="total-price" required/>'
    $('.my-table input::-webkit-outer-spin-button').css('-webkit-appearance', 'none')

    // Remove item when i click on the delete button

    $('.btn-danger').click(function () {
        $(this).parents('tr:first').remove()
    })
})

let currency

let observer = new MutationObserver(record => {
    $('.my-table input, .my-table .btn-danger').on('blur click keyup', function (e) {
        // reformat the unit-price with commas and 2 decimal points
        if (e.type === 'keyup' || e.type === 'click') {
            if ($(this)[0].className === 'unit-price') {
                currency = $(this).val().match('^[a-zA-Z]..')
                let unit_price_original = getPrice($(this).val())
                let formatted_unit_price = currency + ' ' + numberWithCommas(unit_price_original)
                $(this).val(formatted_unit_price)
            }
        } else if (e.type === 'blur') {
            if ($(this)[0].className === 'unit-price') {
                $(this).val(currency + ' ' + numberWithCommas(getPrice($(this).val()).toFixed(2)))
            }
        }

        // calculate the total-price of each unit
        $('.unit-price').each(function (i, unit_price_input) {
            let unit_price = $(unit_price_input).val();
            unit_price = getPrice(unit_price)
            let total_price_input = $('.total-price')[i]
            unit_quantity = $('.unit-quantity')[i].value
            $(total_price_input).val(currency + ' ' + numberWithCommas((unit_quantity * unit_price).toFixed(2)))

        })

        // calculate the subtotal price
        let subtotal = 0
        $('.total-price').each(function (i, total_price){
            total_price = getPrice($(total_price).val())
            subtotal += total_price
        })
        $('#subtotal input').val(currency + ' ' + numberWithCommas(subtotal.toFixed(2)))

        // calculate the vat
        let vat = subtotal * 11/100
        $('#vat input').val(currency + ' ' + numberWithCommas(vat.toFixed(2)))

        // calculate the C/V
        if (currency[0] === 'USD') {
            $('#cv input').val('LBP ' + numberWithCommas((vat * 1570).toFixed(2)))
        } else {
            $('#cv input').val('')
        }


        // calculate the Total
        let total = vat + subtotal
        $('input[name=total-float]').val(total)
        $('#total input').val(currency + ' ' + numberWithCommas(total.toFixed(2)))

        let price_in_words = currencyToWords(total)
        $('#price-in-words').html(price_in_words + ' ' + currency)
        $('input[name=total-in-words]').val(price_in_words + ' ' + currency)

        $('input[name=currency]').val(currency)
    })
});

$(document).on('blur', '#total input', function (){
    let total = $('#total input').val().match('\\d+.+\\d')
    let total_floor = Math.floor(total)
    $('#total input').val(currency + ' ' + numberWithCommas(total))
    let price_in_words = currencyToWords(total_floor)
    $('#price-in-words').html(price_in_words + ' ' + currency)
    $('input[name=total-in-words]').val(price_in_words + ' ' + currency)
})

let target = $('.my-table tbody')[0] ?? null

if (target) {
    observer.observe(target, {
        childList: true
    })
}

$(document).on('click', '.customers-list-item', function (e) {
    let customer_id = e.target.value
    let customer_name = e.target.innerHTML
    $('input[name=customer-id]').val(customer_id).trigger('change')
    $('input[name=customer-name]').val(customer_name)
    $('#customers-list').hide()
})

$(document).on('change', 'input[name=customer-id]', function (e) {
    let customer_id = e.target.value
    $.ajax({
        url: '/autofill/' + customer_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('input[name=customer-name]').val(data['customer']['name'])
            $('input[name=customer-address]').val(data['customer']['address'])
            $('input[name=customer-mof]').val(data['customer']['mof'])
            $('input[name=customer-phone]').val(data['customer']['phone_number'])
        }
    })
})

$(document).on('keyup', 'input[name=customer-search]', function (e) {
    let query = e.target.value
    console.log(query.trim())
    $.ajax({
        url: '/fetch-customers/' + query,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data['customers'])
            $('.customers-table-body tr').remove()
            $(data['customers']).each(function (i, customer) {
                $('.customers-table-body tbody').append(
                    '<tr>' +
                    '<td width="50%">' + customer["name"] + '</td>' +
                    '<td width="50%" style="text-align: center">' +
                    '<button class="delete-btn">\n' +
                    '   <i class="material-icons delete-icon">delete</i>\n' +
                    '</button>\n' +
                    '<button class="edit-btn">\n' +
                    '   <i class="material-icons edit-icon">edit</i>\n' +
                    '</button>' +
                    '</td>' +
                    '</tr>'
                )
            })
        }
    })
})

function getPrice(price) {
    price = price.match(/\d+/g)
    if (price[price.length - 1] === '00') {
        price.pop()
    }
    return parseInt(price.join(''));
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function currencyToWords(currency) {
    return 'Only ' + numberToWords(currency).split(',')
        .join(' And')
        .replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g, letter => letter.toUpperCase())
}
