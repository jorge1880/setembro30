<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Aula;

class UpdateMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Pega o material da rota
        $material = $this->route('material');

        // Garante que o usuário é professor e dono do material
        if (!$this->user() || !$this->user()->professor || $material->professor_id !== $this->user()->professor->id) {
            return false;
        }

        // Garante que a aula selecionada também pertence ao professor
        $aula = Aula::find($this->input('aula_id'));
        if ($aula && $aula->id_user == $this->user()->id) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'aula_id' => 'required|exists:aulas,id',
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:arquivo,link',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,jpg,png,jpeg|max:10240', // Max 10MB
            'link' => 'nullable|url',
            'descricao' => 'nullable|string|max:1000',
        ];
    }
}
