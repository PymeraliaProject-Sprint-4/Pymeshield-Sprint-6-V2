<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CompanyController extends Controller
{
    public function index(){

        if (!auth()->user()->can('dashadmin.companies')) {
            abort(403, 'No tienes permisos');
        }
        else{
            return view('llistatEmpreses.show');
        }

    }

    public function listCompanies(){
        $companies = Company::select(['id','name','email','phone','cif'])
                            ->whereNull('hidden')
                            ->orderBy('updated_at', 'desc')
                            ->get();
    
        return $companies;
    }

    public function indexhidden(){
        return view('llistatEmpreses.empreseshiden');
    }

    public function listcompanieshiddenDatos(){
        $companies = Company::select(['id','name','email','phone','cif'])
                            ->whereNotNull('hidden')
                            ->orderBy('updated_at', 'desc')
                            ->get();
    
        return $companies;
    }

    public function unHideCompany($id){

        $company = Company::find($id);
        $company->hidden = null;
        $company->save();
        $companyId = $company->id;

        $company =  Company::whereNotNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json([
            'id' => $companyId,
            'companies' => $company,
        ]);

    }
    
    
    public function storeCompany(Request $request){
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->cif =   $request->cif;
        $company->save();
    }

    public function editCompany(Request $request){
        $requestData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'cif' => 'required|string'
        ]);

        $company = Company::findOrFail($request->id);
        $company->update($requestData);
    }

    public function unsuscribeCompany(Request $request){
        $request->validate([
            'removed_reason' => 'nullable|max:255|string',
        ]);

        $currentTime = Carbon::now();


        $company = Company::findOrFail($request->id);
        $company->removed_reason =  $request->removed_reason;
        $company->hidden = $currentTime->toDateTimeString();
        $company->update();
    }
}
