function bind_html_load_more(data, url) {
    var html = '';
    if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            html += '<div class="item-product">';
            html += '<a href="' + url + '?id=' + data[i].id + '">';
            html += '<img src="' + data[i].image_url + '" alt="' + data[i].title + '"/>';
            html += '<p>' + data[i].title + '</p>';
            html += '<span>$ ' + convert_number_to_money(data[i].price) + '</span>';
            html += '</a>';
            html += '</div>';
        }
    }
    return html;
}

function convert_number_to_money(value) {
    return String(value).replace(/(.)(?=(\d{3})+$)/g, '$1.')

}