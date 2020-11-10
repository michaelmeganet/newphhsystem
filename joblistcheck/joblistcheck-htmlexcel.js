/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var testTable = document.getElementById('reportTable');
            new TableExport(testTable, {
                sheetname: 'worksheet',
                position: 'top',
                bootstrap: 'true',
                filename: 'batch_checkList',
                formats: ['csv','xlsx']
            });