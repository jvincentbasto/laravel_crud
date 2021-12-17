<div class="w-full h-full">

  <div class="h-auto flex justify-between mb-4">
    <div class="h-full flex">
      <a class="h-full flex items-center pr-4 font-bold text-2xl">{{ $settings->title }}</a>
    </div>

    <div class="h-full flex items-center">
      <a href="{{ $settings->link }}/create" class="h-9 px-4 py-2 rounded bg-teal-500 text-white cursor-pointer shadow-lg hover:shadow text-sm
      hover:bg-teal-600
      focus:outline-2 focus:outline-offset-2 focus:outline-teal-600">Add {{ $settings->title }}</a>
    </div>
  </div>

  <div class="w-full mb-4">
    <form action="{{ $settings->link }}" method="GET">
      <div class="flex justify-end">
        <input type="text" class="w-full md:w-2/6 h-8 py-4 px-3 border-2 border-zinc-300 rounded text-zinc-600 mr-4 text-sm focus:outline-none focus:border-zinc-400" id="query" name="query">
        <button class="px-4 py-2 rounded bg-cyan-500 text-white cursor-pointer shadow-lg hover:shadow text-sm 
        hover:bg-cyan-600
        focus:outline-2 focus:outline-offset-2 focus:outline-cyan-600">Search</button>
      </div>
    </form>
  </div>

  <table class="w-full table-fixed text-left rounded-md shadow-lg shadow-zinc-400">
    <thead class="bg-zinc-900 text-zinc-200">
      <tr>
        <th class="actions">Actions</th>
        @if($columns && count($columns) > 0)
          @foreach($columns as $column)
            <th>
              @if($filters && $filters->sort == $column->name )
                <form action="{{ $settings->link }}" method="GET">
                  <input type="hidden" name="sort" value="{{ $column->name }}" />
                  <input type="hidden" name="order" value="{{ $filters->order }}" />
                  <button class="w-full text-left font-bold cursor-pointer focus:outline-none">
                    {{ $column->title }}
                    @if($filters->order == 'asc') ↓
                    @else ↑
                    @endif
                  </button>
                </form>
              @else
                <form action="{{ $settings->link }}" method="GET">
                  <input type="hidden" name="sort" value="{{ $column->name }}" />
                  <input type="hidden" name="order" value="desc" />
                  <button class="w-full text-left font-bold cursor-pointer focus:outline-none">{{ $column->title }}</button>
                </form>
              @endif
            </th>
          @endforeach
        @endif
      </tr>
    </thead>
    
    @if($list && $list['rows'] && count($list['rows']) > 0)
      <tbody>
        @foreach($list['rows'] as $row)
          <tr >

            <td class="actions">
              <div class="flex h-full items-center">
                <div class="h-full flex items-center">
                  <a href="{{ $settings->link }}/{{ $row->id }}/edit" class="px-4 py-2 rounded bg-emerald-500 text-white cursor-pointer shadow-lg hover:shadow mr-2 text-sm 
                  hover:bg-emerald-600
                  focus:outline-2 focus:outline-offset-2 focus:outline-emerald-600">Edit</a>
                </div>

                <div class="h-full flex items-center">
                  <form method="POST" action="{{ $settings->link }}/{{ $row->id }}" class="m-0">
                    @csrf
                    @method('DELETE')

                    <button class="px-4 py-2 rounded bg-rose-500 text-white cursor-pointer shadow-lg hover:shadow text-sm 
                    hover:bg-rose-600
                    focus:outline-2 focus:outline-offset-2 focus:outline-rose-600">Delete</button>
                  </form>
                </div>
              </div>
            </td>

            @foreach($row->cells as $cell)
              <td>{{ $cell }}</td>
            @endforeach

          </tr>
        @endforeach
      <tbody>
    @else 
      <tbody class="tbody-no-records">
        <tr class="tr-no-records">
          <td class="td-no-records">
            <h4 class="font-bold text-2xl">No Data Records</h4>
          </td>
        </tr>
      </tbody>
    @endif
  </table>

  <div class="mt-12 mb-16">
    @if($list && $list['pages']) 
      @if($querylink) 
        {{ $list['pages']->withQueryString()->links() }}
      @else
        {{ $list['pages']->links() }}
      @endif
    @endif
  </div>
    
</div>


<style type="text/css">
  table {
    width: 100%;
    text-align: left;
    position: relative;
    overflow: hidden;
  }
  tbody {
    min-height: 250px;
  }

  td, th {
    border: 1px solid #dddddd;
    padding: 10px;
  }
  th {
    padding: 15px;
  }
  td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }

  .actions {
    width: 155px;
    min-width: 155px;
  }



  .tbody-no-records {
    display: inline-table;
    width: 100%;
    height: 100%;
  }
  .tr-no-records {
    width: 100%;
    height: 100%;

    position: absolute;
  }
  .td-no-records {
    border: none;
    width: 100%;
    height: 100%;

    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: -3%;
  }

</style>