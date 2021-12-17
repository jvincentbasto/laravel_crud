<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;



class TableColumns {

  public $name;
  public $title;

  public function __construct($name,$title){
    $this->name = $name;
    $this->title = $title;
  }
}

class ColumnFilter {

  public $sort;
  public $order;

  public function __construct($sort,$order){
    $this->sort = $sort;
    $this->order = $order;
  }
}

class ComponentSettings {

  public $title;
  public $link;

  public function __construct($title,$link){
    $this->title = $title;
    $this->link = $link;
  }
}

class FormInputs {

  public $type;
  public $id;
  public $name;
  public $title;
  public $value;

  public function __construct($type,$id,$name,$title,$value){
    $this->type = $type;
    $this->id = $id;
    $this->name = $name;
    $this->title = $title;
    $this->value = $value;
  }
}


class Form {


  public $filters = [];
  public $inputs = [];
  public $form = [];

  public $table;
  public $table_columns = [];
  public $excludes = [];
  public $types = [];

  public $slug = [];


  public function __construct($table,$table_columns,$excludes,$types,$slug){
    $this->table = $table;
    $this->table_columns = $table_columns;
    $this->excludes = $excludes;
    $this->types = $types;
    $this->slug = $slug;
  }


  public function generate_form() {

    function inputType($type) {
      $value;

      if($type == 'text' || $type == 'string') $value = '';
      if($type == 'number') $value = 0;
      if($type == 'date') $value = date("m/d/Y");

      return $value;
    }


    if(count($this->table_columns) > 0) {

      foreach($this->table_columns as $column) {
        if(count($this->excludes) > 0) {
          if(!in_array($column,$this->excludes)) array_push($this->filters,$column);
        }
      }


      if(count($this->filters) > 0) {
        foreach($this->filters as $item) {
          foreach($this->types as $key => $type) {
            if(in_array($item,$type)) {
              
              $title = ucwords(str_replace(['-','_'], " ",$item));
              $value = inputType($key);
              if($this->table && $this->table->{$item}) $value = $this->table->{$item};
              // if($key == 'text' && is_string($value)) $value = ucwords($value);
              if($key == 'number' && is_numeric($value)) $value = number_format(intval($value));


              $input = new FormInputs($key,$item,$item,$title,$value);
              array_push($this->inputs,$input);
            }
          }
        }
      }


      $this->form = [
        'id' => $this->table->id ? $this->table->id : null,
        'slug' => $this->slug,
        'inputs' => $this->inputs
      ];
    }

    return $this->form;
  }
}


class TableCellList {

  public $id;
  public $cells;

  public function __construct($id,$cells){
    $this->id = $id;
    $this->cells = $cells;
  }
}

class TableList {

  public $table;
  public $columns = [];
  public $excludes = [];
  public $pages = [];

  public $rows = [];
  public $list = [];


  public function __construct($table,$columns,$excludes){
    $this->table = $table;
    $this->columns = $columns;
    $this->excludes = $excludes;
  }


  public function generate_tablelist() {

    foreach($this->table as $prop) {
      $item = [];

      if(count($this->columns) > 0) {
        foreach($this->columns as $column) {
          if(!in_array($column,$this->excludes)) 
            $value = $prop[$column];
            if(is_numeric($value)) $value = number_format(intval($value));
            array_push($item,$value);
        }
      }

      if(count($item) > 0) {
        $book = new TableCellList($prop->id,$item);
        array_push($this->rows,$book);
      }
    }

    $this->list = [
      'rows' => $this->rows,
      'pages' => $this->table
    ];

    return $this->list; 
  }
}




class PostsController extends Controller
{
  public function index()
  {

    $columns = [
      new TableColumns('title','Title'),
      new TableColumns('content','Content'),
    ];


    $querylink = false;
    $sort = 'created_at';
    $order = 'desc';


    if(request('sort') && request('order')) {
      $querylink = true;
      $sort = request('sort');

      if(request('order') == 'desc') $order = 'asc';
      else $order = 'desc';
    }

    $filters = new ColumnFilter($sort,$order);
    $settings = new ComponentSettings('Posts','/posts');


    if(request('query')) {
      return $this->search($columns,$filters,$settings);
    }
    else {
      $posts = Post::orderBy($sort,$order)->paginate(10);
      $pages = $posts;

      $table = new Post;
      $table_columns = $table->getTableColumns();
      $excludes = ['id','created_at','updated_at'];

      $list = [];
      $table_list = new TableList($posts,$table_columns,$excludes);
      $list = $table_list->generate_tablelist();
      return view('posts.index', compact('list','columns','filters','querylink','settings'));
    }
  }

  public function create(Post $post)
  { 

    $form = [];
    $posts = new Post;
    $table_columns = $posts->getTableColumns();
    $excludes = ['id','created_at','updated_at'];
    $types = [
      'text' => ['title','content'],
    ];

    $new_form = new Form($post,$table_columns,$excludes,$types,'/posts');
    $form = $new_form->generate_form();
    return view('posts.create',compact('form'));
  }

  public function store()
  {
    request()->validate([
      'title' => 'required',
      'content' => 'required',
    ]);

    Post::create([
      'title' => request('title'),
      'content' => request('content')
    ]);

    return redirect('/posts');
  }

  public function edit(Post $post)
  {

    $form = [];
    $posts = new Post;
    $table_columns = $posts->getTableColumns();
    $excludes = ['id','created_at','updated_at'];
    $types = [
      'text' => ['title','content'],
    ];

    $new_form = new Form($post,$table_columns,$excludes,$types,'/posts');
    $form = $new_form->generate_form();
    return view('posts.edit',compact('form'));
  }

  public function update(Post $post)
  {
    request()->validate([
      'title' => 'required',
      'content' => 'required',
    ]);

    $post->update([
      'title' => request('title'),
      'content' => request('content'),
    ]);

    return redirect('/posts');
  }

  public function destroy(Post $post)
  {
    $post->delete();
    return redirect('/posts');
  }

  public function search($columns,$filters,$settings) {

    $query = '%' . request('query') . '%';
    $excludes = [request('query'),'id','created_at','updated_at'];

    $table = new Post;
    $table_columns = $table->getTableColumns();


    $posts = Post::where('title', 'like', $query)
      ->orWhere(function($p) use ($query,$table_columns,$excludes) {
        foreach($table_columns as $column) {
          
          if(!in_array($column,$excludes)) {
            $p->orWhere($column, 'like', $query);
          }
        
          /*foreach($excludes as $exclude) {
            if($column != $exclude) {
              $p->orWhere($column, 'like', $query);
            }
          }*/
        }
      })
      ->orderBy('created_at','desc')
      ->paginate(10);
      // ->get()->sortByDesc('created_at');
    $list = $posts;
    $querylink = true;

    $list = [];
    $exclude_cells = ['id','created_at','updated_at'];
    $table_list = new TableList($posts,$table_columns,$exclude_cells);
    $list = $table_list->generate_tablelist();

    return view('posts.index', compact('list','columns','filters','querylink','settings'));
  }
}


