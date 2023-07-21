$(document).ready(function () {
    $('.btn-plus').click(function () {
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find('#priceId').html().replace("kyats", ""));
        console.log($price)
        $qty = Number($parentNode.find('#qty').val());
        $total = $price * $qty;
        $parentNode.find('#total').html($total + " kyats");
        summaryCaluculaton();
    })

    $('.btn-minus').click(function () {
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find('#priceId').html().replace("kyats", ""));
        $qty = Number($parentNode.find('#qty').val());
        $total = $price * $qty;
        $parentNode.find('#total').html($total + " kyats");
        summaryCaluculaton();
    })

    $('.btnRemove').click(function () {
        $parentNode = $(this).parents("tr");
        $parentNode.remove();
        summaryCaluculaton();

    })
    function summaryCaluculaton() {
        $totalPrice = 0;
        $('#dataTable tr').each(function (index, row) {
            $totalPrice += Number($(row).find('#total').text().replace("kyats", " "))
        });
        $('#subtotal').html(`${$totalPrice} kyats`)
        $('#final').html(`${$totalPrice + 3000} kyats`)
    }
})
