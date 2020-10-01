@extends('layout')

@section('content')
<meta name="_token" content="{{csrf_token()}}" />

      <div class="container">
        <h3>LifeTrack Medical Systems</h3>
        <hr/>
         <div class="alert alert-success" style="display:none"></div>
         <form id="myForm">
            <div class="form-group">
              <label for="studyday">Number of study per day:</label>
              <input type="number" min="1" class="form-control" id="studyday">
            </div>
            <div class="form-group">
              <label for="studygrowth">Number of Study Growth:</label>
              <input type="number" min="1" class="form-control" id="studygrowth">
            </div>
            <div class="form-group">
               <label for="forecastmonths">Number of months to forecast:</label>
               <input type="number" min="1" max="12" class="form-control" id="forecastmonths">
             </div>
            <button class="btn btn-primary" id="ajaxSubmit">Submit</button>
          </form>

          <table id="myTable" class="table table-striped">
            <thead>
              <th>
                <td>Month Year</td>
                <td>Number studies</td>
                <td>Cost forecasted</td>
                <td>Storage cost</td>
              </th>
            </thead>
            <tbody></tbody>
          </table>
      </div>

      <script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>
      <script>
         jQuery(document).ready(function(){

            jQuery('#ajaxSubmit').click(function(e){
               e.preventDefault();

                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                      'Authorization': "Bearer " + $('meta[name="_token"]').attr('content')
                  }
                });

                jQuery.ajax({
                  url: "{{ url('/api/articles') }}",
                  method: 'post',
                  data: {
                     studyday: jQuery('#studyday').val(),
                     studygrowth: jQuery('#studygrowth').val(),
                     forecastmonths: jQuery('#forecastmonths').val()
                  },
                  success: function(result){
                     jQuery('.alert').show();
                     jQuery('.alert').html(result.success);
                     // console.log(result['months']);

                     html = "";
                     $('#myTable tbody tr td').remove();

                     for (i in result['results']['month']) {
                        html += "<tr>";
                        html += "<td>"+i+"</td>";
                        html += "<td>"+result['results']['month'][i]['name']+"</td>";
                        html += "<td>"+result['results']['month'][i]['studiesperday']+"</td>";
                        html += "<td>$"+result['results']['month'][i]['costperhour']+"</td>";
                        html += "<td>$"+result['results']['month'][i]['costpermonth']+"</td>";
                        html += "</tr>";
                      }

                     $('#myTable tbody').append(html);

                }});
            });

              $('input[type="number"]').change(function() {
                  var max = parseInt($(this).attr('max'));
                  var min = parseInt($(this).attr('min'));
                  if ($(this).val() > max)
                  {
                      $(this).val(max);
                  }
                  else if ($(this).val() < min)
                  {
                      $(this).val(min);
                  }       
              }); 

              jQuery.ajax({
                  url: "{{ url('/api/login') }}",
                  method: 'post',
                  data: { // hardcoded for now
                     email: "admin123@test.com",
                     password: "testman"
                  },
                  success: function(result){
                     $('meta[name="_token"]').attr('content',result.data.api_token)
              }});

            });
      </script>

@endsection