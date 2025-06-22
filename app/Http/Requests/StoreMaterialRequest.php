<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Aula;

class StoreMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Garante que o usuário é um professor autenticado
        if (!$this->user() || !$this->user()->professor) {
            return false;
        }

        // Só pode adicionar material em aulas que ele mesmo criou
        $aula = \App\Models\Aula::find($this->input('aula_id'));
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
            'arquivo' => 'required_if:tipo,arquivo|file|mimes:pdf,doc,docx,ppt,pptx,zip,jpg,png,jpeg|max:10240', // Max 10MB
            'link' => 'required_if:tipo,link|url',
            'descricao' => 'nullable|string|max:1000',
        ];
    }
}
