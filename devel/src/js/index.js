/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var Session = new SessionControl();

function SetEvents(){
	ChangeDatabaseEvent();
}


function ChangeDatabaseEvent(){
	$("#ChangeDatabase").click(
		function(){
			var name = "SelectDatabase";
			var value = $("#SelectableDatabase").val();
			Session.setSession(name, value);
		}
	);
}