<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\User;
use App\Models\InstrumentData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InstrumentController extends Controller
{
    // Display a listing of the instruments
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all'); // Default filter: 'all'
        $pageSize = $request->get('page_size', 10); // Default items per page: 10
    
        $query = Instrument::query(); // Start the query
    
        // Apply time-based filters
        if ($filter === 'today') {
            $query->whereDate('tgl', Carbon::today()); // Today's data (using tgl instead of created_at)
        } elseif ($filter === 'this_month') {
            // Filter by current month and year
            $query->whereMonth('tgl', Carbon::now()->month)
                  ->whereYear('tgl', Carbon::now()->year); // This month's data
        }
    
        // Retrieve filtered data with pagination
        $instruments = $query->orderBy('tgl', 'DESC') // Sort by date (newest first)
                              ->orderBy('jam', 'DESC') // Then by time
                              ->paginate($pageSize); 
    
        // Append query parameters to pagination links
        $instruments->appends($request->all());
    
        // Return view with instrument list
        return view('instrument.index', compact('instruments', 'filter', 'pageSize'));
    }

    // Display the specified instrument
     // Display the specified instrument
     public function show($id)
     {
         try {
             // Find instrument by ID - no need to load user relation anymore
             $instrument = Instrument::findOrFail($id);
         
             // Decode JSON fields with error handling
             try {
                 $nama_instrument = json_decode($instrument->nama_instrument, true);
                 $kondisi = json_decode($instrument->kondisi, true);
                 $keterangan = json_decode($instrument->keterangan, true);
                 
                 // Ensure we have arrays
                 $nama_instrument = is_array($nama_instrument) ? $nama_instrument : [];
                 $kondisi = is_array($kondisi) ? $kondisi : [];
                 $keterangan = is_array($keterangan) ? $keterangan : [];
             } catch (\Exception $e) {
                 // Handle JSON parsing errors
                 return redirect()->route('instruments')
                     ->with('error', 'Data instrumen tidak valid: ' . $e->getMessage());
             }
         
             // Determine maximum length of arrays
             $maxLength = max(count($nama_instrument), count($kondisi), count($keterangan));
             
             // If no data is available
             if ($maxLength === 0) {
                 return redirect()->route('instruments')
                     ->with('error', 'Data instrumen kosong atau tidak valid.');
             }
         
             // Return view with instrument data
             return view('instrument.show', compact(
                 'instrument', 
                 'nama_instrument', 
                 'kondisi', 
                 'keterangan', 
                 'maxLength'
             ));
         } catch (\Exception $e) {
             return redirect()->route('instruments')
                 ->with('error', 'Instrumen tidak ditemukan: ' . $e->getMessage());
         }
     }
    // Show the form for creating a new instrument
    public function create()
    {
        $instruments = InstrumentData::orderBy('nama_instrument')->get();
        // We no longer need to get users since we're using a text input
        $shift = $this->getShift(); // Automatic shift detection
    
        return view('instrument.create', compact('instruments', 'shift'));
    }

    
    // Determine shift based on current time
    private function getShift()
    {
        $hour = now()->hour;
    
        if ($hour >= 0 && $hour < 8) {
            return 'Malam'; // Night shift
        } elseif ($hour >= 8 && $hour < 16) {
            return 'Pagi';  // Morning shift
        } else {
            return 'Siang'; // Afternoon shift
        }
    }

    // Store a newly created instrument in storage
       // Store a newly created instrument in storage
       public function store(Request $request)
       {
           // Validate input data
           $validated = $request->validate([
               'nama_instrument' => 'required|array',
               'kondisi' => 'required|array',
               'keterangan' => 'nullable|array',
               'nama' => 'required|string|max:100', // Changed to string validation instead of exists:users,id
               'shift' => 'required|string|in:Pagi,Siang,Malam',
               'tgl' => 'required|date_format:Y-m-d',
               'jam' => 'required|date_format:H:i',
           ]);
           
           // Custom validation for keterangan fields when kondisi is "Rusak"
           foreach ($validated['kondisi'] as $index => $condition) {
               if ($condition === 'Rusak' && empty($validated['keterangan'][$index])) {
                   return redirect()->back()
                       ->withInput()
                       ->withErrors(['keterangan.'.$index => 'Keterangan harus diisi jika kondisi Rusak']);
               }
           }
       
           try {
               // Create new Instrument instance
               $instrument = new Instrument();
               
               // Set instrument data
               $instrument->nama = $validated['nama'];
               $instrument->nama_instrument = json_encode(array_values($validated['nama_instrument']));
               $instrument->kondisi = json_encode(array_values($validated['kondisi']));
               
               // Handle keterangan - ensure it's an array even if some are empty
               $keterangan = [];
               foreach ($validated['nama_instrument'] as $index => $name) {
                   $keterangan[] = $validated['keterangan'][$index] ?? '';
               }
               $instrument->keterangan = json_encode($keterangan);
               
               // Set additional data
               $instrument->shift = $validated['shift'];
               $instrument->tgl = $validated['tgl'];
               $instrument->jam = $validated['jam'];
               
               // Save to database
               $instrument->save();
               
               return redirect()->route('instruments')
                   ->with('success', 'Data kondisi instrument berhasil ditambahkan!');
           } catch (\Exception $e) {
               return redirect()->back()
                   ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                   ->withInput();
           }
       }
    
    // Show the form for editing the specified instrument
    public function edit($id)
    {
        try {
            $instrument = Instrument::findOrFail($id);
            $instruments = InstrumentData::orderBy('nama_instrument')->get();
            $users = User::where('level', 'Operator Lab')->get();
            
            // Decode JSON fields
            $nama_instrument = json_decode($instrument->nama_instrument, true) ?? [];
            $kondisi = json_decode($instrument->kondisi, true) ?? [];
            $keterangan = json_decode($instrument->keterangan, true) ?? [];
            
            return view('instrument.edit', compact(
                'instrument',
                'instruments',
                'users',
                'nama_instrument',
                'kondisi',
                'keterangan'
            ));
        } catch (\Exception $e) {
            return redirect()->route('instruments')
                ->with('error', 'Instrumen tidak ditemukan.');
        }
    }
    
    // Update the specified instrument in storage
    public function update(Request $request, $id)
    {
        // Validate input data
        $validated = $request->validate([
            'nama_instrument' => 'required|array',
            'kondisi' => 'required|array',
            'keterangan' => 'nullable|array',
            'nama' => 'required|string',
            'shift' => 'required|string|in:Pagi,Siang,Malam',
            'tgl' => 'required|date_format:Y-m-d',
            'jam' => 'required|date_format:H:i',
        ]);
        
        try {
            $instrument = Instrument::findOrFail($id);
            
            // Update instrument data
            $instrument->nama = $validated['nama'];
            $instrument->nama_instrument = json_encode($validated['nama_instrument']);
            $instrument->kondisi = json_encode($validated['kondisi']);
            $instrument->keterangan = json_encode($validated['keterangan'] ?? []);
            $instrument->shift = $validated['shift'];
            $instrument->tgl = $validated['tgl'];
            $instrument->jam = $validated['jam'];
            
            $instrument->save();
            
            return redirect()->route('instruments')
                ->with('success', 'Data kondisi instrument berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // Remove the specified instrument from storage
    public function destroy($id)
    {
        try {
            $instrument = Instrument::findOrFail($id);
            
            // Check if user has permission to delete
            // Since 'nama' is now just a string and not a user ID, we can only check admin level
            if (auth()->user()->level !== 'Admin') {
                return redirect()->back()
                    ->with('error', 'Anda tidak memiliki izin untuk menghapus data ini.');
            }
            
            $instrument->delete();
            
            return redirect()->route('instruments')
                ->with('success', 'Data kondisi instrument berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    
}
