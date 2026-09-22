<?php

namespace App\Controller\Test;

use App\Entity\Experiences;
use App\Entity\Information;
use App\Entity\Skill;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use function Symfony\Component\Translation\t;

final class DataBaseTestController extends AbstractController
{

  
    

//    #[Route('/test/users', name: 'app_test_data_base_test')]
    public function index(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {

        $users_data = <<<TEXT
[
 {"firstname":"Alice","lastname":"Martin","email":"alice.martin@example.com","password":"TestPass001","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 1"},
  {"firstname":"Lucas","lastname":"Bernard","email":"lucas.bernard@example.com","password":"TestPass002","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 2"},
  {"firstname":"Emma","lastname":"Dubois","email":"emma.dubois@example.com","password":"TestPass003","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 3"},
  {"firstname":"Hugo","lastname":"Thomas","email":"hugo.thomas@example.com","password":"TestPass004","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 4"},
  {"firstname":"Chloe","lastname":"Robert","email":"chloe.robert@example.com","password":"TestPass005","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 5"},
  {"firstname":"Louis","lastname":"Richard","email":"louis.richard@example.com","password":"TestPass006","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 6"},
  {"firstname":"Lea","lastname":"Petit","email":"lea.petit@example.com","password":"TestPass007","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 7"},
  {"firstname":"Gabriel","lastname":"Durand","email":"gabriel.durand@example.com","password":"TestPass008","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 8"},
  {"firstname":"Manon","lastname":"Leroy","email":"manon.leroy@example.com","password":"TestPass009","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 9"},
  {"firstname":"Arthur","lastname":"Moreau","email":"arthur.moreau@example.com","password":"TestPass010","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 10"},
  {"firstname":"Camille","lastname":"Simon","email":"camille.simon@example.com","password":"TestPass011","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 11"},
  {"firstname":"Nathan","lastname":"Laurent","email":"nathan.laurent@example.com","password":"TestPass012","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 12"},
  {"firstname":"Sarah","lastname":"Lefebvre","email":"sarah.lefebvre@example.com","password":"TestPass013","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 13"},
  {"firstname":"Thomas","lastname":"Michel","email":"thomas.michel@example.com","password":"TestPass014","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 14"},
  {"firstname":"Julie","lastname":"Garcia","email":"julie.garcia@example.com","password":"TestPass015","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 15"},
  {"firstname":"Antoine","lastname":"David","email":"antoine.david@example.com","password":"TestPass016","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 16"},
  {"firstname":"Laura","lastname":"Bertrand","email":"laura.bertrand@example.com","password":"TestPass017","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 17"},
  {"firstname":"Maxime","lastname":"Roux","email":"maxime.roux@example.com","password":"TestPass018","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 18"},
  {"firstname":"Clara","lastname":"Vincent","email":"clara.vincent@example.com","password":"TestPass019","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 19"},
  {"firstname":"Paul","lastname":"Fournier","email":"paul.fournier@example.com","password":"TestPass020","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 20"},
  {"firstname":"Sophie","lastname":"Morel","email":"sophie.morel@example.com","password":"TestPass021","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 21"},
  {"firstname":"Alexandre","lastname":"Girard","email":"alexandre.girard@example.com","password":"TestPass022","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 22"},
  {"firstname":"Marion","lastname":"Andre","email":"marion.andre@example.com","password":"TestPass023","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 23"},
  {"firstname":"Julien","lastname":"Lefevre","email":"julien.lefevre@example.com","password":"TestPass024","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 24"},
  {"firstname":"Anais","lastname":"Mercier","email":"anais.mercier@example.com","password":"TestPass025","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 25"},
  {"firstname":"Romain","lastname":"Dupont","email":"romain.dupont@example.com","password":"TestPass026","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 26"},
  {"firstname":"Elise","lastname":"Lambert","email":"elise.lambert@example.com","password":"TestPass027","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 27"},
  {"firstname":"Benjamin","lastname":"Bonnet","email":"benjamin.bonnet@example.com","password":"TestPass028","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 28"},
  {"firstname":"Charlotte","lastname":"Francois","email":"charlotte.francois@example.com","password":"TestPass029","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 29"},
  {"firstname":"Mathieu","lastname":"Martinez","email":"mathieu.martinez@example.com","password":"TestPass030","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 30"},
  {"firstname":"Louise","lastname":"Legrand","email":"louise.legrand@example.com","password":"TestPass031","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 31"},
  {"firstname":"Victor","lastname":"Gauthier","email":"victor.gauthier@example.com","password":"TestPass032","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 32"},
  {"firstname":"Margot","lastname":"Garni­er","email":"margot.garnier@example.com","password":"TestPass033","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 33"},
  {"firstname":"Alexis","lastname":"Chevalier","email":"alexis.chevalier@example.com","password":"TestPass034","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 34"},
  {"firstname":"Jeanne","lastname":"Robin","email":"jeanne.robin@example.com","password":"TestPass035","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 35"},
  {"firstname":"Adrien","lastname":"Masson","email":"adrien.masson@example.com","password":"TestPass036","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 36"},
  {"firstname":"Pauline","lastname":"Roy","email":"pauline.roy@example.com","password":"TestPass037","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 37"},
  {"firstname":"Martin","lastname":"Boyer","email":"martin.boyer@example.com","password":"TestPass038","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 38"},
  {"firstname":"Eva","lastname":"Denis","email":"eva.denis@example.com","password":"TestPass039","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 39"},
  {"firstname":"Simon","lastname":"Fontaine","email":"simon.fontaine@example.com","password":"TestPass040","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 40"},
  {"firstname":"Nina","lastname":"Clement","email":"nina.clement@example.com","password":"TestPass041","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 41"},
  {"firstname":"Pierre","lastname":"Morin","email":"pierre.morin@example.com","password":"TestPass042","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 42"},
  {"firstname":"Ines","lastname":"Nicolas","email":"ines.nicolas@example.com","password":"TestPass043","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 43"},
  {"firstname":"Theo","lastname":"Henry","email":"theo.henry@example.com","password":"TestPass044","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 44"},
  {"firstname":"Lucie","lastname":"Roussel","email":"lucie.roussel@example.com","password":"TestPass045","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 45"},
  {"firstname":"Kevin","lastname":"Mathieu","email":"kevin.mathieu@example.com","password":"TestPass046","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 46"},
  {"firstname":"Amandine","lastname":"Gautier","email":"amandine.gautier@example.com","password":"TestPass047","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 47"},
  {"firstname":"Florian","lastname":"Masson","email":"florian.masson@example.com","password":"TestPass048","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 48"},
  {"firstname":"Helene","lastname":"Marchand","email":"helene.marchand@example.com","password":"TestPass049","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 49"},
  {"firstname":"Damien","lastname":"Duval","email":"damien.duval@example.com","password":"TestPass050","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 50"},
  {"firstname":"Celine","lastname":"Denis","email":"celine.denis@example.com","password":"TestPass051","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 51"},
  {"firstname":"Nicolas","lastname":"Dumont","email":"nicolas.dumont@example.com","password":"TestPass052","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 52"},
  {"firstname":"Marine","lastname":"Marie","email":"marine.marie@example.com","password":"TestPass053","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 53"},
  {"firstname":"Olivier","lastname":"Noel","email":"olivier.noel@example.com","password":"TestPass054","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 54"},
  {"firstname":"Justine","lastname":"Meyer","email":"justine.meyer@example.com","password":"TestPass055","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 55"},
  {"firstname":"Yann","lastname":"Dufour","email":"yann.dufour@example.com","password":"TestPass056","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 56"},
  {"firstname":"Valerie","lastname":"Blanc","email":"valerie.blanc@example.com","password":"TestPass057","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 57"},
  {"firstname":"Jerome","lastname":"Besson","email":"jerome.besson@example.com","password":"TestPass058","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 58"},
  {"firstname":"Fanny","lastname":"Perrin","email":"fanny.perrin@example.com","password":"TestPass059","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 59"},
  {"firstname":"Baptiste","lastname":"Morvan","email":"baptiste.morvan@example.com","password":"TestPass060","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 60"},
  {"firstname":"Laura","lastname":"Colin","email":"laura.colin@example.com","password":"TestPass061","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 61"},
  {"firstname":"Etienne","lastname":"Mallet","email":"etienne.mallet@example.com","password":"TestPass062","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 62"},
  {"firstname":"Aurelie","lastname":"Renaud","email":"aurelie.renaud@example.com","password":"TestPass063","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 63"},
  {"firstname":"Gregory","lastname":"Arnaud","email":"gregory.arnaud@example.com","password":"TestPass064","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 64"},
  {"firstname":"Melanie","lastname":"Picard","email":"melanie.picard@example.com","password":"TestPass065","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 65"},
  {"firstname":"Cedric","lastname":"Roger","email":"cedric.roger@example.com","password":"TestPass066","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 66"},
  {"firstname":"Noemie","lastname":"Gilbert","email":"noemie.gilbert@example.com","password":"TestPass067","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 67"},
  {"firstname":"Loic","lastname":"Lemoine","email":"loic.lemoine@example.com","password":"TestPass068","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 68"},
  {"firstname":"Adeline","lastname":"Caron","email":"adeline.caron@example.com","password":"TestPass069","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 69"},
  {"firstname":"Fabien","lastname":"Delaunay","email":"fabien.delaunay@example.com","password":"TestPass070","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 70"},
  {"firstname":"Emilie","lastname":"Aubert","email":"emilie.aubert@example.com","password":"TestPass071","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 71"},
  {"firstname":"Sebastien","lastname":"Leclerc","email":"sebastien.leclerc@example.com","password":"TestPass072","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 72"},
  {"firstname":"Clemence","lastname":"Bourgeois","email":"clemence.bourgeois@example.com","password":"TestPass073","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 73"},
  {"firstname":"Guillaume","lastname":"Lacroix","email":"guillaume.lacroix@example.com","password":"TestPass074","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 74"},
  {"firstname":"Maelle","lastname":"Gillet","email":"maelle.gillet@example.com","password":"TestPass075","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 75"},
  {"firstname":"Frederic","lastname":"Poulain","email":"frederic.poulain@example.com","password":"TestPass076","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 76"},
  {"firstname":"Agathe","lastname":"Allard","email":"agathe.allard@example.com","password":"TestPass077","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 77"},
  {"firstname":"Quentin","lastname":"Paris","email":"quentin.paris@example.com","password":"TestPass078","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 78"},
  {"firstname":"Solene","lastname":"Brun","email":"solene.brun@example.com","password":"TestPass079","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 79"},
  {"firstname":"Renaud","lastname":"Vidal","email":"renaud.vidal@example.com","password":"TestPass080","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 80"},
  {"firstname":"Lola","lastname":"Carlier","email":"lola.carlier@example.com","password":"TestPass081","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 81"},
  {"firstname":"Alexandre","lastname":"Lecomte","email":"alexandre.lecomte@example.com","password":"TestPass082","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 82"},
  {"firstname":"Iris","lastname":"Benard","email":"iris.benard@example.com","password":"TestPass083","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 83"},
  {"firstname":"Robin","lastname":"Gomez","email":"robin.gomez@example.com","password":"TestPass084","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 84"},
  {"firstname":"Maya","lastname":"Fernandez","email":"maya.fernandez@example.com","password":"TestPass085","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 85"},
  {"firstname":"Enzo","lastname":"Bailly","email":"enzo.bailly@example.com","password":"TestPass086","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 86"},
  {"firstname":"Lina","lastname":"Barbier","email":"lina.barbier@example.com","password":"TestPass087","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 87"},
  {"firstname":"Oscar","lastname":"Prevost","email":"oscar.prevost@example.com","password":"TestPass088","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 88"},
  {"firstname":"Zoé","lastname":"Perrot","email":"zoe.perrot@example.com","password":"TestPass089","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 89"},
  {"firstname":"Sacha","lastname":"Lejeune","email":"sacha.lejeune@example.com","password":"TestPass090","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 90"},
  {"firstname":"Jade","lastname":"Pelletier","email":"jade.pelletier@example.com","password":"TestPass091","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 91"},
  {"firstname":"Liam","lastname":"Bouvier","email":"liam.bouvier@example.com","password":"TestPass092","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 92"},
  {"firstname":"Mia","lastname":"Delattre","email":"mia.delattre@example.com","password":"TestPass093","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 93"},
  {"firstname":"Ethan","lastname":"Rolland","email":"ethan.rolland@example.com","password":"TestPass094","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 94"},
  {"firstname":"Louna","lastname":"Le Roux","email":"louna.leroux@example.com","password":"TestPass095","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 95"},
  {"firstname":"Tom","lastname":"Rey","email":"tom.rey@example.com","password":"TestPass096","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 96"},
  {"firstname":"Ambre","lastname":"Cousin","email":"ambre.cousin@example.com","password":"TestPass097","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 97"},
  {"firstname":"Noah","lastname":"Giraud","email":"noah.giraud@example.com","password":"TestPass098","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 98"},
  {"firstname":"Léonie","lastname":"Meunier","email":"leonie.meunier@example.com","password":"TestPass099","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 99"},
  {"firstname":"Adam","lastname":"Bertin","email":"adam.bertin@example.com","password":"TestPass100","description":"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam asperiores laudantium, maxime nostrum aliquam illum harum fuga tempore inventore atque, nesciunt consequuntur doloribus, cupiditate vitae modi dicta accusantium tenetur quas. de test numéro 100"}
]
TEXT;
        $users = json_decode($users_data, true);
        foreach ($users as $user) {
            $entityManager->persist($serializer->deserialize(json_encode($user), User::class, 'json'));
            $entityManager->flush();
        }

        return $this->render('test/data_base_test/index.html.twig', [
            'controller_name' => 'Test/DataBaseTestController',
        ]);
    }


//    #[Route("/test/info", name: "test_info")]
    public function information(UserRepository $userRip,
                                SerializerInterface $serializer,
                                EntityManagerInterface $entityManager): Response
    {
        $info_data = <<<TEXT
[
  {
    "town": "Analamanga",
    "city": "Antananarivo",
    "phone": "+261 34 00 111 01",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "17:00:00",
    "exception": "Samedi 08:00 à 11:30",
    "adress": "Analakely, Antananarivo"
  },
  {
    "town": "Analamanga",
    "city": "Antananarivo",
    "phone": "+261 34 00 111 02",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:30:00",
    "closedhour": "17:30:00",
    "exception": "Samedi 08:30 à 12:00",
    "adress": "Andraharo, Antananarivo"
  },
  {
    "town": "Analamanga",
    "city": "Antananarivo",
    "phone": "+261 34 00 111 03",
    "openday": "Mardi",
    "closedday": "Dimanche",
    "openhour": "09:00:00",
    "closedhour": "18:00:00",
    "exception": "Samedi 09:00 à 13:00",
    "adress": "Ivandry, Antananarivo"
  },
  {
    "town": "Vakinankaratra",
    "city": "Antsirabe",
    "phone": "+261 34 00 111 04",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "16:30:00",
    "exception": "Samedi 08:00 à 12:00",
    "adress": "Centre-ville, Antsirabe"
  },
  {
    "town": "Atsinanana",
    "city": "Toamasina",
    "phone": "+261 34 00 111 05",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "07:30:00",
    "closedhour": "16:00:00",
    "exception": "Samedi 07:30 à 11:30",
    "adress": "Bazary Be, Toamasina"
  },
  {
    "town": "Boeny",
    "city": "Mahajanga",
    "phone": "+261 34 00 111 06",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "17:00:00",
    "exception": "Samedi 08:00 à 12:00",
    "adress": "Mahajanga Be, Mahajanga"
  },
  {
    "town": "Diana",
    "city": "Antsiranana",
    "phone": "+261 34 00 111 07",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "16:00:00",
    "exception": "Samedi 08:00 à 11:30",
    "adress": "Centre-ville, Antsiranana"
  },
  {
    "town": "Haute Matsiatra",
    "city": "Fianarantsoa",
    "phone": "+261 34 00 111 08",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:30:00",
    "closedhour": "17:00:00",
    "exception": "Samedi 08:30 à 12:00",
    "adress": "Ambatomena, Fianarantsoa"
  },
  {
    "town": "Atsimo-Andrefana",
    "city": "Toliara",
    "phone": "+261 34 00 111 09",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "07:30:00",
    "closedhour": "16:30:00",
    "exception": "Samedi 07:30 à 11:00",
    "adress": "Sanfil, Toliara"
  },
  {
    "town": "Sava",
    "city": "Sambava",
    "phone": "+261 34 00 111 10",
    "openday": "Mardi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "17:00:00",
    "exception": "Samedi 08:00 à 12:00",
    "adress": "Centre-ville, Sambava"
  },
  {
    "town": "Analanjirofo",
    "city": "Fenoarivo Atsinanana",
    "phone": "+261 34 00 111 11",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "16:30:00",
    "exception": "Samedi 08:00 à 11:30",
    "adress": "Centre-ville, Fenoarivo Atsinanana"
  },
  {
    "town": "Alaotra-Mangoro",
    "city": "Moramanga",
    "phone": "+261 34 00 111 12",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:30:00",
    "closedhour": "17:30:00",
    "exception": "Samedi 08:30 à 12:00",
    "adress": "Centre-ville, Moramanga"
  },
  {
    "town": "Amoron'i Mania",
    "city": "Ambositra",
    "phone": "+261 34 00 111 13",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "17:00:00",
    "exception": "Samedi 08:00 à 12:00",
    "adress": "Centre-ville, Ambositra"
  },
  {
    "town": "Ihorombe",
    "city": "Ihosy",
    "phone": "+261 34 00 111 14",
    "openday": "Mardi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "16:00:00",
    "exception": "Samedi 08:00 à 11:30",
    "adress": "Centre-ville, Ihosy"
  },
  {
    "town": "Menabe",
    "city": "Morondava",
    "phone": "+261 34 00 111 15",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "07:30:00",
    "closedhour": "16:30:00",
    "exception": "Samedi 07:30 à 11:30",
    "adress": "Nosikely, Morondava"
  },
  {
    "town": "Melaky",
    "city": "Maintirano",
    "phone": "+261 34 00 111 16",
    "openday": "Lundi",
    "closedday": "Samedi",
    "openhour": "08:00:00",
    "closedhour": "17:00:00",
    "exception": "Vendredi 08:00 à 12:00",
    "adress": "Centre-ville, Maintirano"
  },
  {
    "town": "Betsiboka",
    "city": "Maevatanana",
    "phone": "+261 34 00 111 17",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "16:30:00",
    "exception": "Samedi 08:00 à 11:30",
    "adress": "Centre-ville, Maevatanana"
  },
  {
    "town": "Androy",
    "city": "Ambovombe",
    "phone": "+261 34 00 111 18",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:30:00",
    "closedhour": "17:00:00",
    "exception": "Samedi 08:30 à 12:00",
    "adress": "Centre-ville, Ambovombe"
  },
  {
    "town": "Anosy",
    "city": "Taolagnaro",
    "phone": "+261 34 00 111 19",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "17:00:00",
    "exception": "Samedi 08:00 à 11:30",
    "adress": "Centre-ville, Taolagnaro"
  },
  {
    "town": "Diana",
    "city": "Nosy Be",
    "phone": "+261 34 00 111 20",
    "openday": "Lundi",
    "closedday": "Dimanche",
    "openhour": "08:00:00",
    "closedhour": "18:00:00",
    "exception": "Samedi 08:00 à 13:00",
    "adress": "Hell-Ville, Nosy Be"
  }
]
TEXT;
        $infos = json_decode($info_data, true);

        $users = $userRip->findAll();
        foreach ($users as $user) {
            $info = $serializer->deserialize(json_encode($infos[random_int(0, count($infos)-1)]), Information::class, 'json');
            $user->addInformation($info);
            $entityManager->persist($info);
            $entityManager->flush();
        }

        return $this->render('test/data_base_test/index.html.twig', [
            'controller_name' => 'Test/DataBaseTestController',
        ]);
    }
    //#[Route('/test/experience', name: 'test_experience')]
    public function exper(UserRepository $users,
                          SerializerInterface $serializer,
                          EntityManagerInterface $entityManager): Response
    {
        $expers_data = <<<TEXT
[
  {
    "title": "Développeur Web",
    "post": "Développeur Full Stack",
    "begin": "2021",
    "end": "2022",
    "description": "Développement et maintenance d'applications web avec Symfony, PHP, JavaScript et MySQL."
  },
  {
    "title": "Développeur Backend",
    "post": "Développeur PHP",
    "begin": "2020",
    "description": "Conception d'API REST et développement de services backend avec PHP et Symfony."
  },
  {
    "title": "Développeur Frontend",
    "post": "Développeur JavaScript",
    "begin": "2022",
    "description": "Création d'interfaces web modernes et responsives avec JavaScript, HTML et CSS."
  },
  {
    "title": "Administrateur Système",
    "post": "Administrateur Linux",
    "begin": "2019",
    "description": "Administration de serveurs Linux, gestion des utilisateurs, sauvegardes et surveillance des services."
  },
  {
    "title": "Ingénieur Logiciel",
    "post": "Software Engineer",
    "begin": "2023",
    "description": "Participation à la conception, au développement et aux tests de solutions logicielles."
  },
  {
    "title": "Chef de Projet IT",
    "post": "Project Manager",
    "begin": "2021",
    "description": "Gestion de projets informatiques, coordination des équipes et suivi des délais et budgets."
  },
  {
    "title": "Technicien Informatique",
    "post": "Technicien Support",
    "begin": "2018",
    "description": "Installation, configuration et maintenance des postes informatiques et assistance aux utilisateurs."
  },
  {
    "title": "Développeur Mobile",
    "post": "Développeur Android",
    "begin": "2022",
    "end": "2023",
    "description": "Développement d'applications mobiles Android et intégration d'API REST."
  },
  {
    "title": "Data Analyst",
    "post": "Analyste de données",
    "begin": "2020",
    "end": "2022",
    "description": "Analyse de données, création de rapports et développement de tableaux de bord décisionnels."
  },
  {
    "title": "Ingénieur DevOps",
    "post": "DevOps Engineer",
    "begin": "2023",
    "end": "2024",
    "description": "Automatisation des déploiements et gestion des infrastructures avec Docker, Git et CI/CD."
  },
  {
    "title": "Consultant Informatique",
    "post": "Consultant IT",
    "begin": "2019",
    "end": "2020",
    "description": "Accompagnement des entreprises dans l'analyse de leurs besoins et la mise en place de solutions informatiques."
  },
  {
    "title": "Développeur Symfony",
    "post": "Développeur PHP Symfony",
    "begin": "2021",
    "end": "2023",
    "description": "Développement d'applications métier avec Symfony, Doctrine, Twig et MySQL."
  },
  {
    "title": "Ingénieur Réseau",
    "post": "Network Engineer",
    "begin": "2018",
    "end": "2019",
    "description": "Configuration et maintenance des réseaux locaux, routeurs, switches et systèmes de sécurité réseau."
  },
  {
    "title": "Responsable Informatique",
    "post": "IT Manager",
    "begin": "2020",
    "end": "2022",
    "description": "Gestion du parc informatique, supervision des équipes techniques et administration des infrastructures."
  },
  {
    "title": "Développeur Junior",
    "post": "Junior Web Developer",
    "begin": "2017",
    "end": "2018",
    "description": "Développement de fonctionnalités web et correction de bugs sous la supervision d'une équipe senior."
  },
  {
    "title": "Architecte Logiciel",
    "post": "Software Architect",
    "begin": "2022",
    "end": "2024",
    "description": "Conception de l'architecture technique des applications et définition des standards de développement."
  },
  {
    "title": "Ingénieur Sécurité",
    "post": "Cybersecurity Engineer",
    "begin": "2021",
    "end": "2022",
    "description": "Mise en place de mesures de sécurité, analyse des vulnérabilités et surveillance des systèmes."
  },
  {
    "title": "Product Owner",
    "post": "Product Owner IT",
    "begin": "2023",
    "end": "2024",
    "description": "Définition des besoins fonctionnels, gestion du backlog et coordination entre les utilisateurs et l'équipe technique."
  },
  {
    "title": "Ingénieur QA",
    "post": "Quality Assurance Engineer",
    "begin": "2019",
    "end": "2021",
    "description": "Mise en place de tests fonctionnels, tests automatisés et contrôle de la qualité des applications."
  },
  {
    "title": "Lead Developer",
    "post": "Tech Lead",
    "begin": "2024",
    "end": "2025",
    "description": "Encadrement d'une équipe de développeurs, revue de code et définition des choix techniques des projets."
  }
]
TEXT;
        $expers = array_map(
            function ($item) {
                if(isset($item["end"])){
                    $item["end"] = (int)$item["end"];
                }
                $item["begin"] = (int)$item["begin"];
                return $item;
            },json_decode($expers_data, true)
        );
        foreach ($users->findAll() as $user) {

            
            $exper = $serializer->deserialize(json_encode($expers[random_int(0, count($expers)-1)]), Experiences::class, 'json');
            $user->addExperience($exper);
            $entityManager->persist($exper);
            $entityManager->flush();
        }

        return $this->render('test/data_base_test/index.html.twig', [
            'controller_name' => 'Test/DataBaseTestController',
        ]);
    }

    #[Route('/test/comp', name: 'test_experience')]
    public function comp(UserRepository $users,
                          SerializerInterface $serializer,
                          EntityManagerInterface $entityManager): Response
    {
      $comp_data = [
        "python", 
        "Java", 
        "Autocad", 
        "Revit", 
        "Permie E", 
        "Covadis", 
        "Sketsup"
      ];

      foreach ($users->findAll() as $user) {
        foreach ($comp_data as $comp) {
          $data = ["name" => $comp, "level" => random_int(1, 5)];
          $c = $serializer->deserialize(json_encode($data), Skill::class, "json");
          $user->addSkill($c);
          $entityManager->persist($c);
          $entityManager->flush();
        }
      }

      return $this->render('test/data_base_test/index.html.twig', [
            'controller_name' => 'Test/DataBaseTestController',
        ]);
    }

    //#[Route('/test/subcat', name: 'test_subcat')]
    public function subcat(UserRepository $users,
                          SubCategoryRepository $subcategory,
                          CategoryRepository $categoryRepository,
                          EntityManagerInterface $entityManager): Response
    {
      $subcategory_data = $subcategory->findAll();
      $rand = [1, 2, 4, 3, 4, 5, 6, 7, 8, 9, 10];
      foreach ($users->findAll() as $user) {
        $randcategoryid = $rand[random_int(0, count($rand) - 1)];
        $domaine = array_filter($subcategory_data, fn($value) => $value->getCategory() === $categoryRepository->find($randcategoryid));
        $i = 0;
        if(count($domaine) <= 2) {
          foreach($domaine as $d) {
              if($i == 2) break;
              $user->addSubCategory($d);
              $entityManager->persist($d);
              $entityManager->flush();
              $i++;
          };
        }else {
          foreach($domaine as $d) {
              if($i == 3) break;
              $user->addSubCategory($d);
              $entityManager->persist($d);
              $entityManager->flush();
              $i++;
          };
        }
      }

      return $this->render('test/data_base_test/index.html.twig', [
            'controller_name' => 'Test/DataBaseTestController',
        ]);
    }

}
