/*product form*/

function checkSize(input) {
    let itemId = input.id.split('-')[1];
    if (input.checked) {
        document.getElementById('size-' + itemId).value += input.value + ',';
    } else {
        let tmp = document.getElementById('size-' + itemId).value.replace(input.value + ',', '');
        document.getElementById('size-' + itemId).value = tmp;
    }
}

function deleteUnitRow(tr) {
    tr.parentNode.removeChild(tr);
}

function addNewRow() {
    let table = document.getElementById('units-table');
    let id = 'newunitid' + (new Date()).getTime();
    let tr = document.createElement('tr');
    tr.id = 'unittr-' + id;
    tr.innerHTML = ROW.replace(/#id#/g, id);
    table.appendChild(tr);
}


/*order form*/

function addItem() {
    var orders = document.getElementById("orders");
    let id = (new Date()).getTime();
    let tr = document.createElement('tr');
    tr.innerHTML = Row.replace(/#id#/g, id);
    orders.appendChild(tr);
    return false;
}

function deleteItem(elem) {
    var orders = document.getElementById("orders");
    var tr = orders.getElementsByTagName("tr");
    if (tr.length != 2) elem.parentNode.removeChild(elem);
    return false;
}

function refreshProduct(select) {
    let unitsSelect = $(select.parentNode.nextSibling.firstChild);
    unitsSelect.empty().append(parseUnits(select.selectedOptions[0].attributes["data-units"].nodeValue));
    refreshUnit(select.parentNode.nextSibling.firstChild);
}

function refreshUnit(select) {
    select.parentNode.lastChild.src = select.selectedOptions[0].attributes["data-img"].nodeValue;
    let selector = $(select.parentNode.nextSibling.firstChild);
    selector.empty().append(parseSizes(select.selectedOptions[0].attributes["data-sizes"].nodeValue));
}

function parseSizes(sizesStr) {
    let result = "";
    let first = true;
    sizesStr.split(",").forEach(function (sizeStr) {
        if (sizeStr) {
            let size = sizeStr.split(":");
            result += "<option value='" + size[0] + "'";
            if (first) {
                result += " selected";
                first = false;
            }
            result += ">" + size[1] + "</option>";
        }
    });
    return result;
}

function parseUnits(unitsStr) {
    let result = "";
    let first = true;
    unitsStr.split(";").forEach(function (unit) {
        if (unit) {
            let arUnit = unit.split("%");
            result += "<option value='" + arUnit[0] + "'";
            if (first) {
                result += " selected";
                first = false;
            }
            result += " data-img='" + arUnit[2] + "' data-sizes='" + arUnit[3] + "'>" + arUnit[1] + "</option>";
        }
    });
    return result;
}