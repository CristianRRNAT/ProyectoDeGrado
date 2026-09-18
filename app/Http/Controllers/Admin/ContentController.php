<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicArea;
use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use App\Models\Opportunity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(string $resource): View
    {
        [$model,$title]=$this->resource($resource);
        $items=$model::query()->latest()->paginate(18);
        return view('admin.content-index',compact('items','resource','title'));
    }

    public function create(string $resource): View { return $this->form($resource,new ($this->resource($resource)[0])); }
    public function edit(string $resource, int $id): View { $model=$this->resource($resource)[0]; return $this->form($resource,$model::findOrFail($id)); }

    private function form(string $resource, Model $item): View
    {
        $title=$this->resource($resource)[1];
        return view('admin.content-form', ['resource'=>$resource,'title'=>$title,'item'=>$item,'departments'=>Department::orderBy('name')->get(),'areas'=>AcademicArea::orderBy('name')->get()]);
    }

    public function store(Request $request,string $resource): RedirectResponse
    {
        $model=$this->resource($resource)[0]; $model::create($this->validated($request,$resource));
        return redirect()->route('admin.content.index',$resource)->with('status','Registro creado correctamente.');
    }

    public function update(Request $request,string $resource,int $id): RedirectResponse
    {
        $model=$this->resource($resource)[0]; $item=$model::findOrFail($id); $item->update($this->validated($request,$resource,$item));
        return redirect()->route('admin.content.index',$resource)->with('status','Registro actualizado correctamente.');
    }

    public function destroy(string $resource,int $id): RedirectResponse
    {
        $model=$this->resource($resource)[0]; $item=$model::findOrFail($id); $item->update(['is_active'=>false]);
        return back()->with('status','Registro desactivado. Sus relaciones fueron conservadas.');
    }

    private function resource(string $resource): array
    {
        return match($resource){'institutions'=>[Institution::class,'Instituciones'],'careers'=>[Career::class,'Carreras'],'opportunities'=>[Opportunity::class,'Oportunidades'],default=>abort(404)};
    }

    private function validated(Request $request,string $resource,?Model $item=null): array
    {
        $request->merge(['is_active'=>$request->boolean('is_active')]);
        if($resource==='careers') $request->merge(['is_traditional'=>$request->boolean('is_traditional')]);
        if($resource==='institutions') return array_merge($request->validate([
            'department_id'=>['required','exists:departments,id'],'name'=>['required','max:180'],'slug'=>['nullable','max:190',Rule::unique('institutions')->ignore($item?->id)],
            'acronym'=>['nullable','max:30'],'institution_type'=>['required','max:60'],'ownership'=>['nullable','max:30'],'payment_type'=>['nullable','max:30'],
            'description'=>['nullable'],'city'=>['required','max:80'],'address'=>['required','max:255'],'phone'=>['nullable','max:50'],'email'=>['nullable','email','max:150'],'website'=>['nullable','url','max:255'],'is_active'=>['boolean'],
        ]),['slug'=>$request->filled('slug')?Str::slug($request->slug):Str::slug($request->name),'is_verified'=>false]);
        if($resource==='careers') return array_merge($request->validate([
            'academic_area_id'=>['nullable','exists:academic_areas,id'],'name'=>['required','max:160'],'slug'=>['nullable','max:170',Rule::unique('careers')->ignore($item?->id)],'degree_level'=>['required','max:80'],
            'duration_text'=>['nullable','max:80'],'summary'=>['required'],'description'=>['nullable'],'professional_field'=>['nullable'],'is_traditional'=>['boolean'],'is_active'=>['boolean'],
        ]),['slug'=>$request->filled('slug')?Str::slug($request->slug):Str::slug($request->name)]);
        return array_merge($request->validate([
            'type'=>['required','in:course,training,scholarship'],'title'=>['required','max:255'],'slug'=>['nullable','max:255',Rule::unique('opportunities')->ignore($item?->id)],'provider'=>['required','max:255'],'description'=>['required'],
            'modality'=>['nullable','max:40'],'cost_type'=>['required','in:free,paid,consult'],'duration'=>['nullable','max:255'],'audience'=>['nullable','max:255'],'requirements'=>['nullable'],'official_url'=>['required','url','max:255'],'availability_status'=>['required','in:open,consult,closed'],'is_active'=>['boolean'],
        ]),['slug'=>$request->filled('slug')?Str::slug($request->slug):Str::slug($request->title),'is_verified'=>false,'currency'=>'BOB']);
    }
}
