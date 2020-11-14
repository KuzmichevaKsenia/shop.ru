function changeDelivery(select){
	if (select.value == "") return;
	if (select.value == "0") document.getElementById("address").style.display = "block";
	else document.getElementById("address").style.display = "none";
}

function changeSize(el){
	$('.span-size').removeClass('active-size');
	el.classList.add('active-size');
	let newSizeId = el.id.split('-')[3];
	let arKeyVal = {7: newSizeId};
	changeLink(arKeyVal);
}

function changeAvailability(el){
	$('.div-availability').removeClass('active-availability');
	el.classList.add('active-availability');
}

function changeSizes(el){
	$('.div-sizes').removeClass('active-sizes');
	el.classList.add('active-sizes');
	changeSize(el.getElementsByClassName('span-size')[0]);
}

function changeImg(el){
	$('.product-image').removeClass('active-img');
	el.classList.add('active-img');
}

function changeColor(el){
	$('.span-color').removeClass('active-color');
	el.classList.add('active-color');
	let newItemId = el.id.split('-')[2];
	let arKeyVal = {5: newItemId};
	changeLink(arKeyVal);
	changeSizes(document.getElementById('div-sizes-' + newItemId));
	changeImg(document.getElementById('unit-img-' + newItemId));
	changeAvailability(document.getElementById('unit-availability-' + newItemId));
}

function changeLink(arKeyVal) {
	let link = document.getElementById('prod-link-cart');
	let arHref = link.href.split(/=|&/);
	for (let key in arKeyVal) {
		arHref[key] = arKeyVal[key];
	}
	let newlink = arHref[0];
	for (let index = 1; index < arHref.length; ++index) {
		if (index & 1) newlink += "=";
		else newlink += "&";
		newlink += arHref[index];
	}
	link.href = newlink;
}