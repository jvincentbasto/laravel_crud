<div class="w-3/6 mx-auto rounded p-8 bg-zinc-50 shadow-lg shadow-zinc-400">

  @if($form && !is_null($form['id']))
    <form method="POST" action="{{ $form['slug'] }}/{{ $form['id'] }}">
    @method('PUT')
  @else
    <form method="POST" action="{{ $form['slug'] }}">
  @endif

    @csrf
    @if($form && ['inputs'] && count($form['inputs']) > 0)
      @foreach($form['inputs'] as $input)
        @if($input->type == 'text')
          <div class="mb-4">
            <label class="font-bold text-zinc-800" for="{{ $input->id }}">{{ $input->title }}:</label>
            <input class="w-full h-10 py-4 px-3 border-2 border-zinc-300 rounded text-zinc-600 text-sm focus:outline-none focus:border-zinc-400" id="{{ $input->id }}" name="{{ $input->name }}" value="{{ old('', $input->value) }}">
          </div>
        @elseif($input->type == 'number')
          <div class="mb-4">
            <label class="font-bold text-zinc-800" for="{{ $input->id }}">{{ $input->title }}:</label>
            <input type="number" class="w-full h-10 py-4 px-3 border-2 border-zinc-300 rounded text-zinc-600 text-sm focus:outline-none focus:border-zinc-400" id="{{ $input->id }}" name="{{ $input->name }}" min="0" value="{{ old(0, $input->value) }}">
          </div>
        @elseif($input->type == 'date')
          <div class="mb-4">
            <label class="font-bold text-zinc-800" for="{{ $input->id }}">{{ $input->title }}:</label>
            <input type="date" class="w-full h-10 py-4 px-3 border-2 border-zinc-300 rounded text-zinc-600 text-sm focus:outline-none focus:border-zinc-400" id="{{ $input->id }}" name="{{ $input->name }}" value="{{ old(date('Y_m_d'), $input->value) }}">
          </div>
        @endif
      @endforeach
    @endif


    <div class="flex mt-8">

      @if($form && !is_null($form['id']))
        <button class="px-4 py-2 rounded bg-emerald-500 text-white cursor-pointer shadow-lg hover:shadow mr-2 text-sm hover:bg-emerald-600
        focus:outline-2 focus:outline-offset-2 focus:outline-emerald-600">Update</button>
      @else
        <button class="px-4 py-2 rounded bg-teal-500 text-white cursor-pointer shadow-lg hover:shadow mr-2 text-sm 
        hover:bg-teal-600
        focus:outline-2 focus:outline-offset-2 focus:outline-teal-600">Create</button>
      @endif

      <div class="h-full flex items-center">
        <a href="{{ $form['slug'] }}/" class="px-4 py-2 rounded bg-zinc-500 text-white cursor-pointer shadow-lg hover:shadow text-sm
        hover:bg-zinc-600 
        focus:outline-2 focus:outline-offset-2 focus:outline-zinc-600">Cancel</a>
      </div>

    </div>
  </form>

</div>