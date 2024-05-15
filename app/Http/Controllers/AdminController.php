<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

/**
 * Clase que se encarga de manejar todas las operaciones que realiza un usuario administrador.
 * @package App\Controllers
 */
class AdminController extends Controller
{

    /**
     * Mostrar la vista principal del BackOffice (Panel de Administración)
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse Vista del BackOffice con los datos necesarios | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function index(): Factory|View|\Illuminate\Foundation\Application|Application|RedirectResponse
    {
        try {
            // Total de usuarios registrados
            $totalRegisteredUsers = User::where('role_id', 2)->count();
            // Total de Blogs publicados
            $totalPostedBlogs = Blog::get()->count();
            // Total de reseñas
            $totalReviews = Review::get()->count();
            // Total de comentarios
            $totalComments = Comment::get()->count();

            // Obtener el número de usuarios registrados por meses
            $totalRegisteredUsersEveryMonth = User::select(
                DB::raw('YEAR(created_at) as year'), // Obtener año de la fecha de creación
                DB::raw('MONTH(created_at) as month'), // Obtener mes de la fecha de creación
                DB::raw('COUNT(*) as total_registered_users') // Conteo total
            )
                ->where('role_id', 2) // Usuarios registrados
                ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth()) // últimos doce meses
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            // Formatear las fechas al castellano
            $monthInSpanish = array(
                1 => "Enero",
                2 => "Febrero",
                3 => "Marzo",
                4 => "Abril",
                5 => "Mayo",
                6 => "Junio",
                7 => "Julio",
                8 => "Agosto",
                9 => "Septiembre",
                10 => "Octubre",
                11 => "Noviembre",
                12 => "Diciembre",
            );
            // Recorrer los valores obtenidos para asignarles dichos meses en castellano
            foreach ($totalRegisteredUsersEveryMonth as $total) {
                $total->month_name = $monthInSpanish[$total->month];
            }

            // Obtenemos usuarios administradores
            $totalAdminUsers = User::where('role_id', 1)->get();

            return view('admin.pages.admin-index', compact('totalRegisteredUsers', 'totalPostedBlogs', 'totalRegisteredUsersEveryMonth', 'totalAdminUsers', 'totalReviews', 'totalComments'));

        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Generar informes de datos en PDF de datos de todos los usuarios.
     *
     * @return RedirectResponse|null PDF para descargarlo localmente | Redirección HTTP en caso de un registro fallido
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function generatePDF(): ?RedirectResponse
    {
        try {
            // Obtener usuarios
            $users = User::all();

            // Crear una nueva instancia de Dompdf
            $dompdf = new Dompdf();

            // Configurar Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf->setOptions($options);

            // Renderizar la vista del informe como HTML
            $html = view('admin.pages.reports.user-report', compact('users'))->render();

            // Cargar el HTML en Dompdf
            $dompdf->loadHtml($html);

            // Renderizar el PDF
            $dompdf->render();

            // Devolver el PDF para descargarlo localmente
            return $dompdf->stream('tabla_usuarios.pdf');

        } catch (Exception $e) {
            session()->flash('error', 'Error en la generación del PDF: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
