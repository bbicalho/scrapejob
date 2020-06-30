const path = require('path');
const fs = require('fs');
const readXlsxFile = require('read-excel-file/node');
//joining path of directory 
const directoryPath = path.join('dist/');
//passsing directoryPath and callback function
arr = [];
fs.readdir(directoryPath, function (err, files) {
	files.forEach(function (file) {
		var name = file;
		var arr = [];
		
		fs.readdir(directoryPath+'/'+name, function (err, files) {
			var count = 0;
			files.forEach(function (file) {
				count++;
				/*readXlsxFile(fs.createReadStream(directoryPath+'/'+name+'/'+file)).then((rows) => {
					console.log(rows);
				  
				})
				*/
				
				//console.log(file);
				fs.rename(directoryPath+'/'+name+'/'+file, directoryPath+'/'+name+'/'+file.split(' - ')[0]+' '+count+'.xlsx', function(err) {if ( err ) console.log(file);});
				//arr.push(file.split('_')[0]);
			});	
		});
		
		//fs.rename(directoryPath+'/'+file, directoryPath+'/'+file.split('_')[0]+'.xlsx', function(err) {if ( err ) console.log(file);});
		//arr.push(file.split('_')[0]);
	});	
});



