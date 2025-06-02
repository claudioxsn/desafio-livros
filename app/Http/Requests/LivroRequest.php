<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LivroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Titulo' => ['required', 'string', 'max:40'],
            'Editora' => ['required', 'string', 'max:40'],
            'Edicao' => ['required', 'integer', 'min:1'],
            'AnoPublicacao' => ['required', 'integer', 'between:1900,' . now()->year],
            'Valor' => ['required', 'numeric', 'min:0'],
            'Livro_CodAu' => ['required', 'array', 'min:1'],
            'Livro_CodAu.*' => ['exists:Autor,CodAu'],
            'Livro_codAs' => ['required', 'array', 'min:1'],
            'Livro_codAs.*' => ['exists:Assunto,CodAs'],
        ];
    }

    public function messages()
    {
        return [
            'Titulo.required'       => 'O campo Título é obrigatório.',
            'Titulo.string'         => 'O campo Título deve conter texto.',
            'Titulo.max'            => 'O campo Título deve ter no máximo 40 caracteres.',

            'Editora.required'      => 'O campo Editora é obrigatório.',
            'Editora.string'        => 'O campo Editora deve conter texto.',
            'Editora.max'           => 'O campo Editora deve ter no máximo 40 caracteres.',

            'Edicao.required'       => 'O campo Edição é obrigatório.',
            'Edicao.integer'        => 'O campo Edição deve ser um número inteiro.',
            'Edicao.min'            => 'O campo Edição deve ser no mínimo 1.',

            'AnoPublicacao.required' => 'O campo Ano de Publicação é obrigatório.',
            'AnoPublicacao.integer'  => 'O campo Ano de Publicação deve ser um número inteiro.',
            'AnoPublicacao.between'  => 'O Ano de Publicação deve estar entre 1900 e o ano atual.',

            'Valor.required'        => 'O campo Valor é obrigatório.',
            'Valor.numeric'         => 'O campo Valor deve ser numérico.',
            'Valor.min'             => 'O campo Valor não pode ser negativo.',

            'Livro_CodAu.required'  => 'Selecione ao menos um autor.',
            'Livro_CodAu.array'     => 'O campo de autores deve ser uma lista.',
            'Livro_CodAu.min'       => 'Selecione pelo menos um autor.',
            'Livro_CodAu.*.exists'  => 'Um ou mais autores selecionados são inválidos.',

            'Livro_codAs.required'  => 'Selecione ao menos um assunto.',
            'Livro_codAs.array'     => 'O campo de assuntos deve ser uma lista.',
            'Livro_codAs.min'       => 'Selecione pelo menos um assunto.',
            'Livro_codAs.*.exists'  => 'Um ou mais assuntos selecionados são inválidos.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors()
        ]));
    }
}
