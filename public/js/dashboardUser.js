var data = [
    {
        "name": "Tiger Nixon",
        "position": "System Architect",
        "salary": "$3,120",
        "start_date": "2011/04/25",
        "office": "Edinburgh",
        "id": "1",

    },
    {
        "name": "Garrett Winters",
        "position": "Director",
        "salary": "$5,300",
        "start_date": "2011/07/25",
        "office": "Edinburgh",
        "id": "2",

    },
    {
        "name": "Tiger Nixon",
        "position": "System Architect",
        "salary": "$3,120",
        "start_date": "2011/04/25",
        "office": "Edinburgh",
        "id": "3",

    },
    {
        "name": "Garrett Winters",
        "position": "Director",
        "salary": "$5,300",
        "start_date": "2011/07/25",
        "office": "Edinburgh",
        "id": "4",

    }
];

var data2 = [
    {
        "name": "Tiger Nixon",
        "position": "8",
        "salary": "300",
        "total": "50000",
        "start_date": "9000",
        "office": "2011/07/25",
        "id": "Bán",

    },
    {
        "name": "Tiger Nixon",
        "position": "8",
        "salary": "300",
        "total": "50000",
        "start_date": "9000",
        "office": "2011/07/25",
        "id": "Mua",

    },
    {
        "name": "Tiger Nixon",
        "position": "8",
        "salary": "300",
        "total": "50000",
        "start_date": "9000",
        "office": "2011/07/25",
        "id": "Bán",

    },
    {
        "name": "Tiger Nixon",
        "position": "8",
        "salary": "300",
        "total": "50000",
        "start_date": "9000",
        "office": "2011/07/25",
        "id": "Mua",

    },


];

$('#product-sell').DataTable({
    data: data,
    columns: [
        { data: 'name' },
        { data: 'position' },
        { data: 'salary' },
        { data: 'office' },
        {
            "data": "id",
            "orderable": false,
            "searchable": false,
            "render": function (data, type, row, meta) { // render event defines the markup of the cell text 
                var a = '<a href="#' + data + '"><i class="fa fa-edit"></i> Mua</a>'; // row object contains the row data
                return a;
            }
        }
    ],
    paging: true,
    searching: true,
    info: true,
    "autoWidth": false,
    "bLengthChange": false,

    "oLanguage": {
        "sLengthMenu": 'Hiển thị  <select>' +
            '<option value="5">5</option>' +
            '<option value="10">10</option>' +
            '<option value="30">30</option>' +
            '<option value="40">40</option>' +
            '<option value="50">50</option>' +
            '<option value="-1">Tất cả</option>' +
            '</select> người',
        "sInfo": "",
        "sSearch": "<span>Tìm kiếm:</span> _INPUT_",
    },
});



$('#product-buy').DataTable({
    data: data,
    columns: [
        { data: 'name' },
        { data: 'position' },
        { data: 'salary' },
        { data: 'office' },
        {
            "data": "id",
            "orderable": false,
            "searchable": false,
            "render": function (data, type, row, meta) { // render event defines the markup of the cell text 
                var a = '<a href="#' + data + '"><i class="fa fa-edit"></i> Bán</a>'; // row object contains the row data
                return a;
            }
        }

    ],
    paging: true,
    searching: true,
    info: true,
    "bLengthChange": false,
    "autoWidth": false,
    "oLanguage": {
        "sInfo": "",
        "sSearch": "<span>Tìm kiếm:</span> _INPUT_",
    },
});


function _tagForTableAccepted(data) {
    if (data === 'Bán')
        return '<button type="button" class="btn btn-success">' + data + '</button>';
    return '<button type="button" class="btn btn-danger">' + data + '</button>';
}



$('#sell-product-accepted').DataTable({
    data: data2,
    columns: [
        { data: 'name' },
        { data: 'position' },
        { data: 'salary' },
        { data: 'total' },
        { data: 'office' },
        {
            "data": "id",
            "orderable": false,
            "searchable": false,
            "render": function (data, type, row, meta) { // render event defines the markup of the cell text 
                var a = _tagForTableAccepted(data); // row object contains the row data
                return a;
            }
        }

    ],
    paging: true,
    searching: true,
    info: true,
    "bLengthChange": false,
    "autoWidth": false,
    "oLanguage": {
        "sInfo": "",
        "sSearch": "<span>Tìm kiếm:</span> _INPUT_",
    },
});


