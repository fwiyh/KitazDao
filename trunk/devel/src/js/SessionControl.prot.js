/**
 * require jquery
 */

SessionControl = function(){
	
};

SessionControl.prototype.setSession = function(name, value){
	$.ajax({
		async: true,
		cache: false,
		url: "./_SetSession.php",
		type: "post",
		dataType: "json",
		data: {
			name: name,
			value: value
		}
	}).done(function(data, textStatus, jqXHR){
		alert("complete");
	}).fail(function(data, textStatus, errorThrown){
		alert(data.status + "\n" + textStatus + "\n" + errorThrown.message);
	}).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
		
	});
};
SessionControl.prototype.getSession = function(name){
	
};
SessionControl.prototype.closeSession = function(name){
	$.ajax({
		async: true,
		cache: false,
		url: "./Unsetsession.php",
		type: "post",
		dataType: "json",
		data: {
			name: name
		}
	}).done(function(data, textStatus, jqXHR){
		
	}).fail(function(data, textStatus, errorThrown){
		
	}).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
		
	});
};