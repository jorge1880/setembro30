<?php

namespace App\Services;

use App\Models\MaterialApoio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaterialApoioService
{
    /**
     * Armazena um novo material de apoio.
     *
     * @param array $validatedData
     * @param int $professorId
     * @return MaterialApoio
     * @throws \Exception
     */
    public function store(array $validatedData, int $professorId): MaterialApoio
    {
        return DB::transaction(function () use ($validatedData, $professorId) {
            $data = $validatedData;
            $data['professor_id'] = $professorId;

            if ($data['tipo'] === 'arquivo' && isset($data['arquivo'])) {
                $data['arquivo'] = $data['arquivo']->store('materiais', 'public');
            }

            return MaterialApoio::create($data);
        });
    }

    /**
     * Atualiza um material de apoio existente.
     *
     * @param array $validatedData
     * @param MaterialApoio $material
     * @return MaterialApoio
     * @throws \Exception
     */
    public function update(array $validatedData, MaterialApoio $material): MaterialApoio
    {
        return DB::transaction(function () use ($validatedData, $material) {
            $data = $validatedData;

            if ($data['tipo'] === 'arquivo') {
                if (isset($data['arquivo'])) {
                    // Se um arquivo antigo existir, remove
                    if ($material->arquivo) {
                        Storage::disk('public')->delete($material->arquivo);
                    }
                    // Armazena o novo arquivo
                    $data['arquivo'] = $data['arquivo']->store('materiais', 'public');
                }
                // Garante que o campo link seja nulo se o tipo for arquivo
                $data['link'] = null;
            } elseif ($data['tipo'] === 'link') {
                // Se um arquivo antigo existir, remove pois o tipo mudou para link
                if ($material->arquivo) {
                    Storage::disk('public')->delete($material->arquivo);
                }
                $data['arquivo'] = null;
            }

            $material->update($data);
            return $material->fresh();
        });
    }

    /**
     * Remove um material de apoio.
     *
     * @param MaterialApoio $material
     * @return void
     * @throws \Exception
     */
    public function destroy(MaterialApoio $material): void
    {
        try {
            DB::transaction(function () use ($material) {
                if ($material->arquivo) {
                    Storage::disk('public')->delete($material->arquivo);
                }
                $material->delete();
            });
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar material de apoio: ' . $e->getMessage());
            throw new \Exception('Erro ao deletar material de apoio: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $material = MaterialApoio::find($id);
            
            if (!$material) {
                return [
                    'success' => false,
                    'message' => '❌ **Material não encontrado!**<br><br>🔧 **Solução:** O material pode ter sido removido por outro usuário.'
                ];
            }

            // Verificar se há comentários associados
            $comentariosCount = $material->comentarios()->count();
            if ($comentariosCount > 0) {
                return [
                    'success' => false,
                    'message' => '⚠️ **Não é possível excluir este material!**<br><br>📚 **Motivo:** Existem <strong>' . $comentariosCount . ' comentário(s)</strong> associado(s) a este material.<br><br>🔧 **Solução:** Primeiro remova os comentários ou transfira-os para outro material.'
                ];
            }

            // Deletar arquivo se existir
            if ($material->arquivo) {
                try {
                    \Storage::disk('public')->delete($material->arquivo);
                } catch (\Exception $e) {
                    \Log::warning('Erro ao deletar arquivo do material: ' . $e->getMessage());
                }
            }

            $material->delete();
            
            return [
                'success' => true,
                'message' => '✅ **Material excluído com sucesso!**'
            ];
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar material de apoio: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.'
            ];
        }
    }
} 