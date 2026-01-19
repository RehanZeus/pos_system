<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $role = session()->get('role');

        if (!empty($arguments) && !in_array($role, $arguments)) {
            // JIKA DITOLAK, LEMPAR KE HALAMAN UTAMA MASING-MASING
            
            if ($role == 'owner') {
                return redirect()->to('/dashboard');
            }
            if ($role == 'gudang') { // UBAH DISINI
                return redirect()->to('/products'); // Gudang -> Produk
            }
            if ($role == 'kasir') {
                return redirect()->to('/pos');      // Kasir -> POS
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}