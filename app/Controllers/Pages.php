<?php

namespace App\Controllers;
use App\Models\EmployeeModel as EmployeeModel;
use App\Models\JabatanModel as JabatanModel;

class Pages extends BaseController
{
    protected $EmployeeModel;
    public function __construct() {
        $this->EmployeeModel = New EmployeeModel();
        $this->JabatanModel = New JabatanModel();
    }
    public function index()
    {
        $data = [
            'title' => 'HOME | WebProgrammingUNPAS'
        ];

        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'ABOUT | WebProgrammingUNPAS'
        ];

        return view('pages/about', $data);
    }

    public function employee($id = false)
    {
        if($id == false) {
            $keyword = $this->request->getVar('keyword');
            if($keyword) {
                $db      = \Config\Database::connect();
                $key = $db->escapeString($keyword);
                $query = $db->query("SELECT * FROM tb_employee WHERE employee_name LIKE '%$key%' OR  employee_salary LIKE '%$key%' OR employee_age LIKE '%$key%'");
                $data_employee = $query->getResultArray();
                $pager = false;
            } else {
                $data_employee = $this->EmployeeModel->paginate(4);
                $pager = $this->EmployeeModel->pager;
            }
            $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
            $data = [
                'title' => 'Lihat Data Karyawan',
                'data_table' => $data_employee,
                'pager' => $pager,
                'page' => $page
            ];
    
            return view('pages/employee', $data);
        } else {
            $data_employee = $this->EmployeeModel->join('tb_jabatan', 'tb_employee.id_jabatan=tb_jabatan.id_jabatan')->find($id);
            $data = [
                'title' => 'Lihat Data Karyawan',
                'data_jabatan' => $this->JabatanModel->findAll(),
                'data_table' => $data_employee
            ];
    
            return view('pages/employee-detail', $data);
        }
    }

    public function secret($id) {
        session()->setFlashdata('secret', 'hengker mau ngapain main-main sama url?');
        return redirect()->to(base_url('/karyawan'));
    }

    public function insertEmployee() 
    {
        $data = [
            'title' => 'INSERT | WebProgrammingUNPAS',
            'data_jabatan' => $this->JabatanModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('pages/insert', $data);
        
    }

    public function saveEmployee()
    {
        $id_jabatan = $this->request->getVar("id_jabatan");
        $inputValue =  [
            'nama' =>  $this->request->getVar("nama"),
            'gaji' =>  $this->request->getVar("gaji"),
            'umur' =>  $this->request->getVar("umur"),
            'id_jabatan' =>  $this->request->getVar("id_jabatan")
        ];
        
        $img = $this->request->getFile('foto');
        if($img->getError() == 4) {
            $img = "profil-kosong.jpeg";
            $newImgName = "profil-kosong.jpeg";
        } else {
            $ext = explode("/", $img->getMimeType())[0];
            if($ext != 'image') {
                session()->setFlashdata('error_upload', 'Hengker jangan upload file aneh-aneh disini ya');             
                session()->setFlashdata('error_value', $inputValue);             
                return redirect()->to(base_url('/insert-karyawan'));
            }
            if($img->getSize() > 5000000) {
                    session()->setFlashdata('error_upload', 'ukuran File Tidak boleh lebih dari 5mb');             
                    session()->setFlashdata('error_value', $inputValue);             
                    return redirect()->to(base_url('/insert-karyawan'));
            }
            $newImgName = $img->getRandomName();
            $img->move('src/img/' , $newImgName);
        }
         if(!$this->validate([
                'nama' => [
                    'rules' => 'max_length[20]|min_length[3]',
                    'errors' => [
                        'max_length[20]' => 'Panjang nama gak boleh lebih dari 20 ya nyet',
                        'min_length[3]' => 'Gak ada yang namanya kurang dari 3 huruf'
                    ]
                ],
                'gaji' => [
                    'rules' => 'integer',
                    'errors' => [
                        'integer' => 'Jangan aneh-aneh ya, input gaji harus diisi nomor'
                    ]
                ],
                'umur' => [
                    'rules' => 'integer',
                    'errors' => [
                        'integer' => 'Jangan aneh-aneh ya, input umur harus diisi nomor'
                    ]
                ]
            ]) or $id_jabatan == 'nothing') {
                $validation = \Config\Services::validation();
                $validate = $validation->getErrors();
                if($id_jabatan == 'nothing') {
                    if(!$validate) {
                        $validate = [ 'id_jabatan' => 'pilih jabatan yang bener!!' ];
                    } else {
                        $validate["id_jabatan"] = 'pilih jabatan yang bener!!';
                    }
                }
                
                session()->setFlashdata('error_message', $validate);             
                session()->setFlashdata('error_value', $inputValue);             
                return redirect()->to(base_url('/insert-karyawan'));
            }
           
            $data_insert = [
                'employee_name' => $this->request->getVar("nama"),
                'employee_salary' => $this->request->getVar("gaji"),
                'employee_age' => $this->request->getVar("umur"),
                'id_jabatan' => $this->request->getVar("id_jabatan"),
                'picture' => $newImgName
            ];
            
            $this->EmployeeModel->insert($data_insert);
            session()->setFlashdata('insert_message', 'data berhasil ditambahkan.');
            return redirect()->to(base_url('/karyawan'));
    }

    public function deleteEmployee() {
        $id = $this->request->getVar('id');
        $data_employee = $this->EmployeeModel->find($id);
        unlink('src/img/' . $data_employee["picture"]);
        session()->setFlashdata('delete_message', 'data ' . $data_employee['employee_name'] . ' berhasil dihapus.');
        $this->EmployeeModel->delete($id);
        return redirect()->to(base_url('/karyawan'));
    }

    public function editEmployee() { 
        $inputValue =  [
            'nama' =>  $this->request->getVar("nama"),
            'gaji' =>  $this->request->getVar("gaji"),
            'umur' =>  $this->request->getVar("umur"),
            'id_jabatan' =>  $this->request->getVar("id_jabatan")
        ];      
        if($this->request->getFile('foto')->getSize() == 0) {
            $newImgName = $this->request->getVar('foto-lama');
        } else {
            $img = $this->request->getFile('foto');
            $ext = explode("/", $img->getMimeType())[0];
            if($ext != 'image') {
                session()->setFlashdata('error_upload', 'Hengker jangan upload file aneh-aneh disini ya');             
                return redirect()->to(base_url('/karyawan/'. $this->request->getVar("id")));
            }
            unlink('src/img/' . $this->request->getVar('foto-lama'));
            if($img->getSize() > 5000000) {
                session()->setFlashdata('error_upload', 'ukuran File Tidak boleh lebih dari 5mb');             
                return redirect()->to(base_url('/karyawan/'. $this->request->getVar("id")));
            }        
            $newImgName = $img->getRandomName();
            $img->move('src/img/' , $newImgName);
        }
        if(!$this->validate([
            'nama' => [
                'rules' => 'max_length[20]|min_length[3]',
                'errors' => [
                    'max_length[20]' => 'Panjang nama gak boleh lebih dari 20 ya nyet',
                    'min_length[3]' => 'Gak ada yang namanya kurang dari 3 huruf'
                ]
            ],
            'gaji' => [
                'rules' => 'integer',
                'errors' => [
                    'integer' => 'Jangan aneh-aneh ya, input gaji harus diisi nomor'
                ]
            ],
            'umur' => [
                'rules' => 'integer',
                'errors' => [
                    'integer' => 'Jangan aneh-aneh ya, input umur harus diisi nomor'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            $validate = $validation->getErrors();
            session()->setFlashdata('error_message', $validate);               
            return redirect()->to(base_url('/karyawan/'. $this->request->getVar("id")));
        }

        $data_lama = $this->EmployeeModel->find($this->request->getVar('id'));
        $data_baru = [
            'employee_name' => $this->request->getVar("nama"),
            'employee_salary' => $this->request->getVar("gaji"),
            'employee_age' => $this->request->getVar("umur"),
            'id_jabatan' => $this->request->getVar("id_jabatan"),
            'picture' => $newImgName
        ];

        $this->EmployeeModel->update($this->request->getVar('id'), $data_baru);
        session()->setFlashdata('update_message', 'data ' . $data_lama["employee_name"] . ' telah berubah');                      
        return redirect()->to(base_url('/karyawan/'. $this->request->getVar("id")));
    }
}
 
