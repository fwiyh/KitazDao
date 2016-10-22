/**
 * require jquery
 */

SessionProc = function(){
	
};

SessionProc.prototype.setSession = function(name, value){
	$.ajax({
		async: true,
		cache: false,
		url: "./_SetSession.php",
		data: {
			name: name,
			value: value
		}
	}).done(function(data, textStatus, jqXHR){
		
	}).fail(function(data, textStatus, errorThrown){
		
	}).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
		
	});
};
SessionProc.prototype.getSession = function($name){
	
};
SessionProc.prototype.closeSession = function($name){
	$.ajax({
		async: true,
		cache: false,
		url: "./Unsetsession.php",
		data: {
			name: name
		}
	}).done(function(data, textStatus, jqXHR){
		
	}).fail(function(data, textStatus, errorThrown){
		
	}).always(function(data, textStatus, returnedObject){ //以前のcompleteに相当。ajaxの通信に成功した場合はdone()と同じ、失敗した場合はfail()と同じ引数を返します。
		
	});
};