<script>
    $(document).ready(function() {
        $('#buttonFilter').click(function(e){
            var search = $('#search').val();
            var field = $('input[name=field]:checked').val();

            $.ajax({
                type: 'POST',
                url: '/car/search',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {search: search, field: field}
            })
            .done(function(response){
                $("#table-body").empty();

                tableData = JSON.parse(response);
                state = {
                    'querySet': tableData,
                    'page': 1,
                    'rows': 10,
                    'window': 10,
                };

                buildTable();
            })
            .fail(function(){
                console.log('Error....');
            })
        });

        var tableData = JSON.parse({!! json_encode($cars, JSON_HEX_TAG) !!});
        var state = {
            'querySet': tableData,
            'page': 1,
            'rows': 10,
            'window': 10,
        };

        buildTable();

        function pagination(querySet, page, rows) {
            var trimStart = (page - 1) * rows
            var trimEnd = trimStart + rows
            var trimmedData = querySet.slice(trimStart, trimEnd)
            var pages = Math.round(querySet.length / rows);

            if(pages == 0) {
                pages = 1;
            }

            return {
                'querySet': trimmedData,
                'pages': pages,
            }
        }

        function pageButtons(pages) {
            var wrapper = document.getElementById('pagination-wrapper')
            wrapper.innerHTML = ``
            var maxLeft = (state.page - Math.floor(state.window / 2))
            var maxRight = (state.page + Math.floor(state.window / 2))

            if (maxLeft < 1) {
                maxLeft = 1
                maxRight = state.window
            }

            if (maxRight > pages) {
                maxLeft = pages - (state.window - 1)
                
                if (maxLeft < 1){
                    maxLeft = 1
                }

                maxRight = pages
            }
            
            for (var page = maxLeft; page <= maxRight; page++) {
                wrapper.innerHTML += `<button value=${page} class="page btn btn-sm btn-info">${page}</button>&nbsp;&nbsp;`
            }

            if (state.page != 1) {
                wrapper.innerHTML = `&nbsp;&nbsp;<button value=${1} class="page btn btn-sm btn-info">&#171; First</button>&nbsp;&nbsp;` + wrapper.innerHTML
            }

            if (state.page != pages) {
                wrapper.innerHTML += `&nbsp;&nbsp;<button value=${pages} class="page btn btn-sm btn-info">Last &#187;</button>`
            }

            $('.page').on('click', function() {
                $('#table-body').empty()
                state.page = Number($(this).val())
                buildTable()
            })
        }

        function buildTable() {
            var table = $('#table-body')
            var data = pagination(state.querySet, state.page, state.rows)
            var myList = data.querySet

            for (var i = 1 in myList) {
                var row = `<tr>
                        <td><a href="/car/${myList[i].slug}">${myList[i].id}</a></td>
                        <td>${myList[i].mark}</td>
                        <td>${myList[i].model}</td>
                        <td>${myList[i].year}</td>
                        <td>${myList[i].updatedAt}</td>
                        <td><img class="car-img" src="/uploads/car_image/${myList[i].imageFilename}"></td>
                        `
                table.append(row)
            }

            pageButtons(data.pages)
        }
    });
</script>
<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Mark</th>
        <th>Model</th>
        <th>Year</th>
        <th>Last update</th>
        <th>Photo</th>
    </tr>
    </thead>
    <tbody id="table-body"></tbody>
</table>

<div class="container ">
    <div id="pagination-wrapper"></div>
</div>