<?php
// [Magfi Adi Radza Putra] - Controller CRUD Tiket TixGo
namespace App\Http\Controllers;

use App\Models\TixgoTicket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    private function getViewPrefix()
    {
        $role = auth()->user()->role;
        return $role === 'super_admin' ? 'superadmin' : 'manager';
    }

    public function index()
    {
        $tickets = TixgoTicket::with('category')->latest()->get();
        $categories = Category::all();
        return view($this->getViewPrefix() . '.tickets.index', compact('tickets', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view($this->getViewPrefix() . '.tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:200',
            'event_date' => 'nullable|date',
        ]);

        TixgoTicket::create([
            'category_id' => $request->category_id,
            'ticket_code' => 'TIX-' . strtoupper(Str::random(8)),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'location' => $request->location,
            'event_date' => $request->event_date,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ticket = TixgoTicket::findOrFail($id);
        $categories = Category::all();
        return view($this->getViewPrefix() . '.tickets.edit', compact('ticket', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:200',
            'event_date' => 'nullable|date',
        ]);

        $ticket = TixgoTicket::findOrFail($id);
        $ticket->update($request->only(['category_id', 'name', 'description', 'price', 'stock', 'location', 'event_date']));

        return redirect()->back()->with('success', 'Tiket berhasil diupdate!');
    }

    public function destroy($id)
    {
        $ticket = TixgoTicket::findOrFail($id);
        $ticket->delete();
        return redirect()->back()->with('success', 'Tiket berhasil dihapus!');
    }
}
