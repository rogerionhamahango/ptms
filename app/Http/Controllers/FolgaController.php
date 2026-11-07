<?php

namespace App\Http\Controllers;

use App\Models\Folga;
use App\Models\SubstituicaoFolga;
use App\Models\Technicians;
use App\Models\Jornalist;
use App\Models\EscalaTecnica;
use App\Models\EscalaLocutores;
use App\Models\Edicoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FolgaController extends Controller
{


    /**
     * Consultar compromissos e substitutos disponíveis dos técnicos.
     */
    public function tecnicos(Request $request)
    {
        abort_unless(
            Auth::user()?->user_role === 'chefeTecnico',
            403,
            'Não tem autorização para gerir as folgas dos técnicos.'
        );

        $dados = $request->validate([
            'funcionario_id' => [
                'nullable',
                'required_with:data',
                'integer',
                'exists:technicians,id',
            ],
            'data' => [
                'nullable',
                'required_with:funcionario_id',
                'date_format:Y-m-d',
            ],
        ]);

        $tecnicos = Technicians::query()
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        $tecnicoSelecionado = null;
        $dataSelecionada = null;
        $compromissos = collect();
        $substitutosPorEscala = [];

        if (
            !empty($dados['funcionario_id'])
            && !empty($dados['data'])
        ) {
            $tecnicoSelecionado = Technicians::findOrFail(
                $dados['funcionario_id']
            );

            $dataSelecionada = $dados['data'];

            $compromissos = EscalaTecnica::where(
                'technician_id',
                $tecnicoSelecionado->id
            )
                ->whereDate('data', $dataSelecionada)
                ->orderBy('turno')
                ->get();

            foreach ($compromissos as $compromisso) {
                $substitutosPorEscala[$compromisso->id] =
                    Technicians::query()
                        ->where('id', '!=', $tecnicoSelecionado->id)

                        // O substituto não pode ter folga nessa data.
                        ->whereNotExists(function ($query) use (
                            $dataSelecionada
                        ) {
                            $query->select(DB::raw(1))
                                ->from('folgas')
                                ->whereColumn(
                                    'folgas.funcionario_id',
                                    'technicians.id'
                                )
                                ->where(
                                    'folgas.funcionario_type',
                                    Technicians::class
                                )
                                ->whereDate(
                                    'folgas.data',
                                    $dataSelecionada
                                );
                        })

                        // Não pode estar escalado no mesmo turno.
                        ->whereNotExists(function ($query) use (
                            $compromisso,
                            $dataSelecionada
                        ) {
                            $query->select(DB::raw(1))
                                ->from('escala_tecnicas')
                                ->whereColumn(
                                    'escala_tecnicas.technician_id',
                                    'technicians.id'
                                )
                                ->whereDate(
                                    'escala_tecnicas.data',
                                    $dataSelecionada
                                )
                                ->where(
                                    'escala_tecnicas.turno',
                                    $compromisso->turno
                                );
                        })

                        ->orderBy('name')
                        ->orderBy('surname')
                        ->get();
            }
        }

        return view('folgas.tecnicos', compact(
            'tecnicos',
            'tecnicoSelecionado',
            'dataSelecionada',
            'compromissos',
            'substitutosPorEscala'
        ));
    }

    /**
     * Folgas dos técnicos.
     */
    public function storeTecnico(Request $request)
    {
        return $this->guardarFolga(
            $request,
            'chefeTecnico',
            Technicians::class,
            'technicians',
            EscalaTecnica::class,
            'technician_id',
            'turno',
            'Folga do técnico registada com sucesso.'
        );
    }


    /**
     * Consultar compromissos e substitutos disponíveis dos locutores.
     */
    public function locutores(Request $request)
    {
        abort_unless(
            Auth::user()?->user_role === 'chefeEmissoes',
            403,
            'Não tem autorização para gerir as folgas dos locutores.'
        );

        $dados = $request->validate([
            'funcionario_id' => [
                'nullable',
                'required_with:data',
                'integer',
                'exists:jornalists,id',
            ],
            'data' => [
                'nullable',
                'required_with:funcionario_id',
                'date_format:Y-m-d',
            ],
        ]);

        $locutores = Jornalist::query()
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        $locutorSelecionado = null;
        $dataSelecionada = null;
        $compromissos = collect();
        $substitutosPorEscala = [];

        if (
            !empty($dados['funcionario_id'])
            && !empty($dados['data'])
        ) {
            $locutorSelecionado = Jornalist::findOrFail(
                $dados['funcionario_id']
            );

            $dataSelecionada = $dados['data'];

            $compromissos = EscalaLocutores::where(
                'jornalist_id',
                $locutorSelecionado->id
            )
                ->whereDate('data', $dataSelecionada)
                ->orderBy('turno')
                ->get();

            foreach ($compromissos as $compromisso) {
                $substitutosPorEscala[$compromisso->id] =
                    Jornalist::query()
                        ->where('id', '!=', $locutorSelecionado->id)

                        // O substituto não pode ter folga nessa data.
                        ->whereNotExists(function ($query) use (
                            $dataSelecionada
                        ) {
                            $query->select(DB::raw(1))
                                ->from('folgas')
                                ->whereColumn(
                                    'folgas.funcionario_id',
                                    'jornalists.id'
                                )
                                ->where(
                                    'folgas.funcionario_type',
                                    Jornalist::class
                                )
                                ->whereDate(
                                    'folgas.data',
                                    $dataSelecionada
                                );
                        })

                        // Não pode estar escalado no mesmo turno.
                        ->whereNotExists(function ($query) use (
                            $compromisso,
                            $dataSelecionada
                        ) {
                            $query->select(DB::raw(1))
                                ->from('escala_locutores')
                                ->whereColumn(
                                    'escala_locutores.jornalist_id',
                                    'jornalists.id'
                                )
                                ->whereDate(
                                    'escala_locutores.data',
                                    $dataSelecionada
                                )
                                ->where(
                                    'escala_locutores.turno',
                                    $compromisso->turno
                                );
                        })

                        ->orderBy('name')
                        ->orderBy('surname')
                        ->get();
            }
        }

        return view('folgas.locutores', compact(
            'locutores',
            'locutorSelecionado',
            'dataSelecionada',
            'compromissos',
            'substitutosPorEscala'
        ));
    }

    /**
     * Folgas dos locutores.
     */
    public function storeLocutor(Request $request)
    {
        return $this->guardarFolga(
            $request,
            'chefeEmissoes',
            Jornalist::class,
            'jornalists',
            EscalaLocutores::class,
            'jornalist_id',
            'turno',
            'Folga do locutor registada com sucesso.'
        );
    }


    /**
     * Consultar edições e substitutos disponíveis.
     */
    public function editores(Request $request)
    {
        abort_unless(
            Auth::user()?->user_role === 'chefeRedacao',
            403,
            'Não tem autorização para gerir as folgas dos editores.'
        );

        $dados = $request->validate([
            'funcionario_id' => [
                'nullable',
                'required_with:data',
                'integer',
                'exists:jornalists,id',
            ],
            'data' => [
                'nullable',
                'required_with:funcionario_id',
                'date_format:Y-m-d',
            ],
        ]);

        $editores = Jornalist::query()
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        $editorSelecionado = null;
        $dataSelecionada = null;
        $compromissos = collect();
        $substitutosPorEscala = [];
        $horarios = \App\Models\Horario::pluck('horas', 'id');

        if (
            !empty($dados['funcionario_id'])
            && !empty($dados['data'])
        ) {
            $editorSelecionado = Jornalist::findOrFail(
                $dados['funcionario_id']
            );

            $dataSelecionada = $dados['data'];

            $compromissos = Edicoes::where(
                'jornalista_id',
                $editorSelecionado->id
            )
                ->whereDate('data', $dataSelecionada)
                ->orderBy('horarios_id')
                ->get();

            foreach ($compromissos as $compromisso) {
                $substitutosPorEscala[$compromisso->id] =
                    Jornalist::query()
                        ->where('id', '!=', $editorSelecionado->id)

                        // O substituto não pode ter folga nessa data.
                        ->whereNotExists(function ($query) use (
                            $dataSelecionada
                        ) {
                            $query->select(DB::raw(1))
                                ->from('folgas')
                                ->whereColumn(
                                    'folgas.funcionario_id',
                                    'jornalists.id'
                                )
                                ->where(
                                    'folgas.funcionario_type',
                                    Jornalist::class
                                )
                                ->whereDate(
                                    'folgas.data',
                                    $dataSelecionada
                                );
                        })

                        // Não pode ter outra edição no mesmo horário.
                        ->whereNotExists(function ($query) use (
                            $compromisso,
                            $dataSelecionada
                        ) {
                            $query->select(DB::raw(1))
                                ->from('edicoes')
                                ->whereColumn(
                                    'edicoes.jornalista_id',
                                    'jornalists.id'
                                )
                                ->whereDate(
                                    'edicoes.data',
                                    $dataSelecionada
                                )
                                ->where(
                                    'edicoes.horarios_id',
                                    $compromisso->horarios_id
                                );
                        })

                        ->orderBy('name')
                        ->orderBy('surname')
                        ->get();
            }
        }

        return view('folgas.editores', compact(
            'editores',
            'editorSelecionado',
            'dataSelecionada',
            'compromissos',
            'substitutosPorEscala',
            'horarios'
        ));
    }


    /**
     * Folgas dos editores.
     */
    public function storeEditor(Request $request)
    {
        return $this->guardarFolga(
            $request,
            'chefeRedacao',
            Jornalist::class,
            'jornalists',
            Edicoes::class,
            'jornalista_id',
            'horarios_id',
            'Folga do editor registada com sucesso.'
        );
    }

/**
 * Visualizar as folgas registadas no PTMS.
 */

public function index(Request $request)
{
    $dados = $request->validate([
        'sector' => ['nullable', 'in:tecnico,locutor,editor'],
        'data_inicio' => ['nullable', 'date_format:Y-m-d'],
        'data_fim' => [
            'nullable',
            'date_format:Y-m-d',
            'after_or_equal:data_inicio',
        ],
    ]);

    // A consulta é pública para todos os visitantes.
    $sector = $dados['sector'] ?? '';
    $sectorDoChefe = 'todos';

    $query = Folga::query()
        ->with([
            'funcionario',
            'autorizadoPor',
            'substituicoes.substituto',
            'substituicoes.escala',
        ])
        ->orderByDesc('data')
        ->orderByDesc('id');

    if ($sector !== '') {
        $query->where('sector', $sector);
    }

    if (!empty($dados['data_inicio'])) {
        $query->whereDate('data', '>=', $dados['data_inicio']);
    }

    if (!empty($dados['data_fim'])) {
        $query->whereDate('data', '<=', $dados['data_fim']);
    }

    $folgas = $query->paginate(15)->withQueryString();

    return view('folgas.index', compact(
        'folgas',
        'sector',
        'dados',
        'sectorDoChefe'
    ));
}


    /**
     * Registar uma folga e as substituições necessárias.
     *
     * Formato:
     * substituicoes[ID_DA_ESCALA] = ID_DO_SUBSTITUTO
     */
    private function guardarFolga(
        Request $request,
        string $papel,
        string $modeloFuncionario,
        string $tabelaFuncionario,
        string $modeloEscala,
        string $campoFuncionario,
        string $campoHorario,
        string $mensagem
    ) {
        abort_unless(
            Auth::user()?->user_role === $papel,
            403,
            'Não tem autorização para gerir estas folgas.'
        );

        $sectorPorPapel = [
        'chefeTecnico' => 'tecnico',
        'chefeEmissoes' => 'locutor',
        'chefeRedacao' => 'editor',
        ];

        $sector = $sectorPorPapel[$papel];

        $dados = $request->validate([
            'funcionario_id' => [
                'required',
                'integer',
                'exists:' . $tabelaFuncionario . ',id',
            ],
            'data' => [
                'required',
                'date_format:Y-m-d',
            ],
            'motivo' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'substituicoes' => [
                'nullable',
                'array',
            ],
            'substituicoes.*' => [
                'required',
                'integer',
                'exists:' . $tabelaFuncionario . ',id',
            ],
        ]);

        $funcionarioId = (int) $dados['funcionario_id'];
        $data = $dados['data'];
        $substituicoes = $dados['substituicoes'] ?? [];

        return DB::transaction(function () use (
            $funcionarioId,
            $data,
            $dados,
            $substituicoes,
            $modeloFuncionario,
            $modeloEscala,
            $campoFuncionario,
            $campoHorario,
            $mensagem,
            $sector
        ) {
            // Impedir duas folgas para a mesma pessoa na mesma data.
            $folgaExistente = Folga::where(
                'funcionario_id',
                $funcionarioId
            )
                ->where('funcionario_type', $modeloFuncionario)
                ->whereDate('data', $data)
                ->exists();

            if ($folgaExistente) {
                throw ValidationException::withMessages([
                    'funcionario_id' =>
                        'Este funcionário já tem uma folga registada nessa data.',
                ]);
            }

            // Obter os compromissos do funcionário nessa data.
            $escalas = $modeloEscala::where(
                $campoFuncionario,
                $funcionarioId
            )
                ->whereDate('data', $data)
                ->lockForUpdate()
                ->get();

            $idsEscala = $escalas->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->all();

            // Rejeitar IDs de escalas que não pertencem ao funcionário.
            foreach (array_keys($substituicoes) as $escalaId) {
                if (!in_array(
                    (string) $escalaId,
                    $idsEscala,
                    true
                )) {
                    throw ValidationException::withMessages([
                        'substituicoes' =>
                            'Uma das escalas indicadas não pertence ao funcionário ou à data seleccionada.',
                    ]);
                }
            }

            // Se houver compromissos, todos precisam de substituto.
            foreach ($escalas as $escala) {
                $substitutoId = $substituicoes[$escala->id]
                    ?? $substituicoes[(string) $escala->id]
                    ?? null;

                if ($substitutoId === null) {
                    throw ValidationException::withMessages([
                        'substituicoes' =>
                            'É necessário indicar um substituto para cada compromisso.',
                    ]);
                }
            }

            // Validar cada substituto antes de criar qualquer registo.
            $atribuicoes = [];

            foreach ($escalas as $escala) {
                $substitutoId = (int) (
                    $substituicoes[$escala->id]
                    ?? $substituicoes[(string) $escala->id]
                );

                if ($substitutoId === $funcionarioId) {
                    throw ValidationException::withMessages([
                        'substituicoes' =>
                            'Um funcionário não pode substituir a si próprio.',
                    ]);
                }

                // O substituto não pode ter folga na mesma data.
                $substitutoDeFolga = Folga::where(
                    'funcionario_id',
                    $substitutoId
                )
                    ->where('funcionario_type', $modeloFuncionario)
                    ->whereDate('data', $data)
                    ->exists();

                if ($substitutoDeFolga) {
                    throw ValidationException::withMessages([
                        'substituicoes' =>
                            'Um dos substitutos já tem folga nessa data.',
                    ]);
                }

                // Verificar se o compromisso já foi substituído.
                $jaSubstituida = SubstituicaoFolga::where(
                    'escala_type',
                    $modeloEscala
                )
                    ->where('escala_id', $escala->id)
                    ->exists();

                if ($jaSubstituida) {
                    throw ValidationException::withMessages([
                        'substituicoes' =>
                            'Um dos compromissos já tem uma substituição registada.',
                    ]);
                }

                // O substituto não pode estar ocupado no mesmo
                // turno ou horário do compromisso a cobrir.
                $ocupado = $modeloEscala::where(
                    $campoFuncionario,
                    $substitutoId
                )
                    ->whereDate('data', $data)
                    ->where($campoHorario, $escala->{$campoHorario})
                    ->exists();

                if ($ocupado) {
                    throw ValidationException::withMessages([
                        'substituicoes' =>
                            'Um dos substitutos já está escalado nesse turno ou horário.',
                    ]);
                }

                // Impedir que o mesmo substituto receba dois
                // compromissos no mesmo turno ou horário.
                $chaveAtribuicao = $substitutoId
                    . '|'
                    . $escala->{$campoHorario};

                if (isset($atribuicoes[$chaveAtribuicao])) {
                    throw ValidationException::withMessages([
                        'substituicoes' =>
                            'O mesmo substituto não pode cobrir dois compromissos no mesmo turno ou horário.',
                    ]);
                }

                $atribuicoes[$chaveAtribuicao] = true;
            }

            // Criar a folga depois de validar todos os compromissos.
                $folga = Folga::create([
                    'funcionario_id' => $funcionarioId,
                    'funcionario_type' => $modeloFuncionario,
                    'sector' => $sector,
                    'data' => $data,
                    'motivo' => $dados['motivo'] ?? null,
                    'autorizado_por' => Auth::id(),
                ]);

            // Registar uma substituição para cada compromisso.
            foreach ($escalas as $escala) {
                $substitutoId = (int) (
                    $substituicoes[$escala->id]
                    ?? $substituicoes[(string) $escala->id]
                );

                SubstituicaoFolga::create([
                    'folga_id' => $folga->id,
                    'escala_id' => $escala->id,
                    'escala_type' => $modeloEscala,
                    'substituto_id' => $substitutoId,
                    'substituto_type' => $modeloFuncionario,
                ]);
            }

            return redirect()
                ->back()
                ->with('success', $mensagem);
        });
    }
}