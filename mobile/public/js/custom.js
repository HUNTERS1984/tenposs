function bind_html_load_more(data, url) {
    var html = '';
    if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            html += '<div class="item-product">';
            html += '<a href="' + url + '/' + data[i].id + '">';
            html += '<img src="' + data[i].image_url + '" alt="' + data[i].title + '"/>';
            html += '<p>' + data[i].title + '</p>';
            html += '<span>$ ' + convert_number_to_money(data[i].price) + '</span>';
            html += '</a>';
            html += '</div>';
        }
    }
    return html;
}

function bind_coupon_load_more(data, url) {
    var html = '';
    if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            html += '<div class="item-coupon imageleft clearfix">';
            html += '<div class="image">';
            html += '<img src="' + data[i].image_url + '" alt="' + data[i].title + '"/>';
            html += '</div>';
            html += '<a href="' + url + '/' + data[i].id + '">';
            if (data[i].hasOwnProperty("coupon_type"))
                html += data[i].coupon_type.name;
            else
                html += '空の入力';
            html += ' </a>';
            html += '<h3>' + data[i].title + '</h3>';
            html += ' <p>' + data[i].description + '</p>';
            html += ' </div>';
            html += ' </div>';
        }
    }
    return html;
}

function convert_number_to_money(value) {
    return String(value).replace(/(.)(?=(\d{3})+$)/g, '$1.')

}

function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);

    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch (e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }

    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}