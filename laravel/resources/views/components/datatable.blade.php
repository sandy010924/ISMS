<div class="table-responsive">
  <table id="table_list" class="table table-striped table-sm text-center border rounded-lg">
    <thead>
      {{ $thead }}
       {{-- <tr>
        <th>日期</th>
        <th>課程名稱</th>
        <th>場次</th>
        <th>報名筆數</th>
        <th>實到人數</th>
        <th></th>
      </tr>  --}}
    </thead>
    <tbody>
      {{ $tbody }}
       {{-- @foreach($courses as $key => $course )
       @foreach(array_combine($courses, $salesregistrations) as $course => $salesregistration) --}}
        {{--<tr>
          <td>{{ date('Y-m-d', strtotime($course->course_start_at)) }}</td>
          <td>{{ $course->name }}</td>
          <td>{{ $course->Events }}</td>
          <td>{{ $courses_apply[$key] }} / <span style="color:red">{{ $courses_cancel[$key] }}</span></td>
          <td>{{ $courses_check[$key] }}</td>
          <td>
            <a href="{{ route('course_check', ['id'=>$course->id]) }}"><button type="button" class="btn btn-success btn-sm">開始報到</button></a>
          </td>
        </tr>
      @endforeach  --}}
    </tbody>
  </table>
</div>