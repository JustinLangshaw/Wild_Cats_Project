//Code for exporting html table as an Excel file

var tableToExcel = (function() {
  //General formatting for Excel sheet
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	
  //Create Excel 	
  return function(table, name) {
	//Get/format today's date
	var monthName = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
	var today = new Date();
	var dd = today.getDate();
	if(dd<10){
		dd = '0'+dd;
	}
	var mm = today.getMonth(); 
	var yyyy = today.getFullYear();
	
	//Title for top of Excel
	var excelTitle = "<p><b><big>Sacramento Feral Resources: "+name+" Table - "+monthName[mm]+" "+dd+", "+yyyy+"</big></b><p>";
	
	//Insert html table in Excel format
    if (!table.nodeType) table = document.getElementById(table)
	var tableBody = table.innerHTML;	

	//<textarea> was causeing textboxes to show up when enable editing in excel
	tableBody = tableBody.replace(/<\/textarea>/g, "");  //remove </textarea>
	tableBody = tableBody.replace(/<textarea(.|\n)*?">/g, "");  //remove<textarea...>		
    var ctx = {worksheet: name || 'Worksheet', table: excelTitle+tableBody}
		
	//Name Excel file
	today = monthName[mm] + '_' + dd + '_' + yyyy;
	var link = document.createElement("a");
	document.body.appendChild(link);
		link.download = name+"_"+today+".xls";
		link.href = uri + base64(format(template, ctx));
		link.click();
  }
})()


