# prepaTestSymfony4
##Préparation au test octobre 2018
### 1 create git project
- create a project on github with README.md
- clone this project on your local project's folder
> git clone url
- open this with your IDE
### 2 install symfony 4 with composer
> composer create-project symfony/website-skeleton prov 
- move prov's content to our project prepaTestSymfony4
- remove prov's folder
- if you work with phpstorm, put /.idea/ into .gitignore
### 3 add security checker
> composer require sensiolabs/security-checker --dev
### 4 create externe DB MySQL
- create datas folder
- create the database schema with Workbench : /datas/prepatestsymfony4.mwb
- export diagram to image: /datas/diagram.png
- real export in localhost (see /datas/export1-structure.sql)
### 5 change .env
change .env
> DATABASE_URL=mysql://root:@127.0.0.1:3306/prepatestsymfony4
### 6 create mapping database
> php bin/console doctrine:mapping:import 'App\Entity' annotation --path=src/Entity 
### 7 create setters and getters for entities
> php bin/console make:entity App\Entity --regenerate
### 8 create PublicController
> php bin/console make:controller PublicController
### 9 change routing
to the root in annotation
> "/", name="accueil"
### 10 install bootstrap 4 CDN
- CDN in base.html.twig
### 11 choose a theme
Free bootstrap basic themes: https://startbootstrap.com/
- I choose:  https://startbootstrap.com/template-overviews/bare/
- we make a good general template.html.twig with bootstrap end block
### 12 export datas
export dats in datas/export2-datas.sql
### 13: menu
in front of PublicController.php
                       
    use App\Entity\Sections;
in index method

    // get Doctrine Manager for all entities
    $entityManager = $this->getDoctrine()->getManager();
    // get all sections in db
    $rub = $entityManager->getRepository(Sections::class)->findAll();
    return $this->render('public/index.html.twig', [
    'sections' => $rub,
    ]);
in index.html.twig
                    
    {% for itemMenu in sections %}
    <li class="nav-item">
        <a class="nav-link" href="./section/
        {{ itemMenu.getIdsections }}">{{ itemMenu.getThetitled }}</a>
    </li>
            {% endfor %}
### 14 - get all articles on index.php 
in front of PublicController.php
        
    // use entity Articles.php
    use App\Entity\Articles;         
in index.html.twig


    // get Doctrine Manager for all entities
        $entityManager = $this->getDoctrine()->getManager();

        // get all sections in db
        $rub = $entityManager->getRepository(Sections::class)->findAll();

        // get all articles from db
        $art = $entityManager->getRepository(Articles::class)->findAll();

        return $this->render('public/index.html.twig', [
            'sections' => $rub,
            'articles' => $art,
        ]);  
### 15 - display all articles on index.html.twig
- no difference for the fields into Articles
- automatical INNER JOIN or new query when we make the link one to many or many to many

        {% for item in articles %}
            <h2>{{ item.getThetitle }}</h2>
            <h3>
                {% for categ in item.getSectionssections %}
                    {{ categ.getThetitled }} |
                {% endfor %}
            </h3>
            <p>{{ item.getThetext|slice(0,350) }} ... </p>
            <h4>Par {{ item.getUsersusers.getTherealname }} 
            le {{ item.getThedate|date("d/m/Y à H \\h i \\m") }}</h4><hr>
        {% endfor %} 
### 16 - divise entete in two parts

    {% block entete_haut %}
            <!-- Navigation -->
            <nav class="navbar navbar-expand-lg navbar-dark
             bg-dark static-top">
            <div class="container">
            <a class="navbar-brand" href="{{ path("accueil") }}"
            >NosActus.be</a>
            <button class="navbar-toggler" type="button" 
            data-toggle="collapse" data-target="#navbarResponsive" 
            aria-controls="navbarResponsive" aria-expanded="false"
             aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
        {% endblock %}             
        {% block menu %}....{% endblock %}
       {% block entete_bas %}
           </div>
           </div>
           </nav>
       {% endblock %} 
### 17 install twig extensions for use truncate     
    composer require twig/extensions
 after in config/packages/twig_extensions, decomment Twig\Extensions\TextExtension:
    
    services:
        _defaults:
            public: false
            autowire: true
            autoconfigure: true
    
        # Uncomment any lines below to activate 
        that Twig extension
        #Twig\Extensions\ArrayExtension: ~
        #Twig\Extensions\DateExtension: ~
        #Twig\Extensions\IntlExtension: ~
        Twig\Extensions\TextExtension: ~
 use truncate in index.html.twig
    
    <p>{{ item.getThetext|truncate(350,true) }}</p>
### 18 create the one article system
 - PublicController.php
    
    /**
         *
         * Matches /article/{id},
         * {id} is a requirement digit: "\d+" for more security
         * to view an article's detail
         *
         * @Route("/article/{id}", name="detail_article", requirements={"id"="\d+"})
         */
        public function oneArticle($id){
            // get Doctrine Manager for all entities
            $entityManager = $this->getDoctrine()->getManager();
    
            // get all sections in db for menu
            $rub = $entityManager->getRepository(Sections::class)->findAll();
    
            // get one article by its "id" from db
            $art = $entityManager->getRepository(Articles::class)->find($id);
    
            // return the Twig's view with 2 arguments
            return $this->render('public/one_article.html.twig', [
                'sections' => $rub,
                'articles' => $art,
            ]);
        }  
- create templates/public/one_article.html.twig
 
### 19 create link's dynamique with path
    
        {{ path("detail_article",{'id': item.getIdarticles}) }}   
    
### 20 create Sections system
  - create oneSection($id) in PublicContraller
  - "if" in twig for active menu, create variable with "set"
  - change the link to dynamique
  - create the good many2many's relation:
    
        // get Doctrine Manager for all entities
                $entityManager = $this->getDoctrine()->getManager();
        
                // get all sections in db for menu
                $rub = $entityManager->getRepository(Sections::class)->findAll();
        
                // get one section by its "id" from db
                $section = $entityManager->getRepository(Sections::class)->find($id);
        
                // get all articles by one section
                $art = $section->getArticlesarticles();
        
                // return the Twig's view with 2 arguments
                return $this->render('public/one_section.html.twig', [
                    'sections' => $rub,
                    'section' => $section,
                    'articles' => $art,
                ]);
### 21 order by for articles
 use findby for order by into index method
 
        $art = $entityManager->getRepository(Articles::class)->
        findBy([],["idarticles"=>"DESC"])
### 22 changer order by in annotation into Sections.php
  - Publiccontroller method oneArticle
  
        // get all articles by one section, it's the easy way, 
        you can use ORDER BY into sections.php entity,
         views annotation before private $articlesarticles;
         $art = $section->getArticlesarticles();
 - in Sections.php add
 >  @ORM\OrderBy({"idarticles" = "DESC"})
    
        /**
             * @var \Doctrine\Common\Collections\Collection
             *
             * @ORM\ManyToMany(targetEntity="Articles", inversedBy="sectionssections")
             * @ORM\OrderBy({"idarticles" = "DESC"})
             * @ORM\JoinTable(name="sections_has_articles",
             *   joinColumns={
             *     @ORM\JoinColumn(name="sections_idsections", referencedColumnName="idsections")
             *   },
             *   inverseJoinColumns={
             *     @ORM\JoinColumn(name="articles_idarticles", referencedColumnName="idarticles")
             *   }
             * )
             */
            private $articlesarticles;
        
### 23 click for sections everywhere with path
 
 > {{ path("detail_section",{"id":categ.getIdsections}) }}
 
### 24 if not article, write a message
 > public/one_section.html.twig
    
    {% if articles is empty %}
            <h3><small>Il n'y a pas encore d'article dans cette rubrique</small>
            <a href="{{ path("accueil") }}">Retour à l'accueil</a></h3><hr>
     {% endif %}
 > public/index.html.twig
        
        {% if articles is empty %}
                <h3>Il n'y a pas encore d'article sur notre site</h3><hr>
        {% endif %}
### 25 fixe article's bug and prepare to make a crud to Articles
  > git branch crudarticle
  > git checkout crudarticle       
### 26 CRUD Articles
    php bin/console make:crud Articles

### 27 change route for future private's acces
    App\Controller\ArticlesController :
 
        /**
         * @Route("/admin/articles")
         */
### 28 corrige __tostring bug         
in Users and Sections
    
    get the name:
    
    public function __toString()
        {
            return (string) $this->getThelogin();
        }
### 29 correct bug new (date)

>must implement interface DateTimeInterface or be null, string returned
        
constructer from Articles when we click on /new
    
     /**
         * Constructor
         */
        public function __construct()
        {
            $this->sectionssections = new \Doctrine\Common\Collections\ArrayCollection();
            $this->setThedate(new \DateTime());
        }
### 30 correct bug many to many
usually, in a many to many relation, there are a complete many to many mapping:
            
            in Sections.php
            
            /**
                 * @var \Doctrine\Common\Collections\Collection
                 *
                 * @ORM\ManyToMany(targetEntity="Articles", inversedBy="sectionssections")
                 * @ORM\OrderBy({"idarticles" = "DESC"})
                 * @ORM\JoinTable(name="sections_has_articles",
                 *   joinColumns={
                 *     @ORM\JoinColumn(name="sections_idsections", referencedColumnName="idsections")
                 *   },
                 *   inverseJoinColumns={
                 *     @ORM\JoinColumn(name="articles_idarticles", referencedColumnName="idarticles")
                 *   }
                 * )
                 */
                private $articlesarticles;
fBut a mappedBy relation in the other classe                
              
              in Articles.php
            
            /**
                 * @var \Doctrine\Common\Collections\Collection
                 *
                 * @ORM\ManyToMany(targetEntity="Sections", mappedBy="articlesarticles")
                 */
                private $sectionssections;

for avoid this potential bug: 
write the complete relation in the 2 classes, but inverse the column and delete the "inversedBy"
    
    in Articles.php
        /**
             * @var \Doctrine\Common\Collections\Collection
             *
             * @ORM\ManyToMany(targetEntity="Sections")
             * @ORM\JoinTable(name="sections_has_articles",
             *   joinColumns={
             *     @ORM\JoinColumn(name="articles_idarticles", referencedColumnName="idarticles")
             *   },
             *   inverseJoinColumns={
             *     @ORM\JoinColumn(name="sections_idsections", referencedColumnName="idsections")
             *   }
             * )
             */
            private $sectionssections;
            
    in Sections.php
        /**
             * @var \Doctrine\Common\Collections\Collection
             *
             * @ORM\ManyToMany(targetEntity="Articles")
             * @ORM\OrderBy({"idarticles" = "DESC"})
             * @ORM\JoinTable(name="sections_has_articles",
             *   joinColumns={
             *     @ORM\JoinColumn(name="sections_idsections", referencedColumnName="idsections")
             *   },
             *   inverseJoinColumns={
             *     @ORM\JoinColumn(name="articles_idarticles", referencedColumnName="idarticles")
             *   }
             * )
             */
             private $articlesarticles;
  
 
### 31 template the admin

 With the same Bootstrap template

### 32 create simple identification
    
 > config/packages/security.yaml
  
        security:
            providers:
                in_memory:
            memory:
                users:
                    admin:
                        password: admin
                        roles: 'ROLE_ADMIN'
            firewalls:
                dev:
                    pattern: ^/(_(profiler|wdt)|css|images|js)/
                    security: false
                main:
                    anonymous: ~
                    http_basic: ~

            access_control:
                - { path: ^/admin, roles: ROLE_ADMIN }

            encoders:
                Symfony\Component\Security\Core\User\User: plaintext
### 33 create links to admin

in the "public"'s templates to "articles_index"
        
        {% for itemMenu in sections %}
        <li class="nav-item">
            <a class="nav-link" href="{{ path("detail_section",{"id":itemMenu.getIdsections}) }}">
            {{ itemMenu.getThetitled }}</a>
        </li>
        {% endfor %}
        <li class="nav-item"> <a class="nav-link" href="{{ path('articles_index')}}">Admin</a></li>
### 34 create system to disconnect from admin
- in config/routes.yaml
        
        the_logout:
            path: /logout
- in config/packages/security.yaml

        main:
            anonymous: ~
            http_basic: ~
            logout:
                path:   the_logout
                target: accueil
we can disconnet to this URL: 
> http://127.0.0.1:8000/logout

(but the cache reconnect us when we click to "admin")
### 35 create links to disconnect from admin
in all admin's templates with the "menu" block

        {% block menu %}
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                <a class="nav-link" href="{{ path("articles_index") }}">
                Accueil de l'administration
                <span class="sr-only">(current)</span>
                </a>
                </li>
                <li class="nav-item"> <a class="nav-link" 
                href="{{ path('the_logout')}}">Déconnexion</a></li>
            </ul>
        {% endblock %}

### 36 translate Admin's templates in french
and create a logical navigation

exemple in articles/index.html.twig

        {% extends 'template.html.twig' %}

        {% block title %}{{parent()}} - Liste des articles{% endblock %}
        {% block menu %}
        <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <a class="nav-link" href="{{ path("articles_index") }}">Accueil de l'administration</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ path('articles_new') }}">Créer un nouvel article</a>
        </li>
        <li class="nav-item"> 
            <a class="nav-link" href="{{ path('the_logout')}}">Déconnexion</a>
        </li>
        </ul>
        {% endblock %}
        {% block contenu %}
         <p class="lead">{% block stitre %}Liste de tous nos articles{% endblock %}</p>
        <table class="table">
        <thead>
            <tr>
                <th>Idarticles</th>
                <th>Thetitle</th>
                <th>Thetext</th>
                <th>Thedate</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
        {% for article in articles %}
            <tr>
                <td>{{ article.idarticles }}</td>
                <td>{{ article.thetitle }}</td>
                <td>{{ article.thetext }}</td>
                <td>{{ article.thedate ? article.thedate|date('Y-m-d H:i:s') : '' }}</td>
                <td>
                    <a href="{{ path('articles_show', {'idarticles': article.idarticles}) }}">voir</a>
                    <a href="{{ path('articles_edit', {'idarticles': article.idarticles}) }}">modifier</a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan="5">pas encore d'article</td>
            </tr>
        {% endfor %}
        </tbody>
        </table>

        <a href="{{ path('articles_new') }}">Créer un nouvel article</a>
    {% endblock %}

### 37 create a login page
1) change
> config/packages/security.yaml

with 

        firewalls:
            # ....
            main:
                anonymous: ~
                form_login:
                    login_path: login
                    check_path: login
                    # the route if your are connected
                    default_target_path: articles_index
                logout:
                    path:   the_logout
                    target: accueil
2) create src/Controller/SecurityController.php with console
> php bin/console make:controller SecurityController

3) replace this generate code with

        namespace App\Controller;

        use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
        use Symfony\Component\Routing\Annotation\Route;
        use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

        class SecurityController extends AbstractController
        {
        /**
         * @Route("/login", name="login")
         */
        public function login(AuthenticationUtils $authenticationUtils)
        {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
        }
    }

4) change de template of this class (security/index.html.twig) with

        {% extends 'template.html.twig' %}
        {% block title %}{{ parent() }} - connexion{% endblock %}

        {% block titre %}{{ parent() }} - connexion{% endblock %}
        {% block stitre %}connectez-vous sur notre site d'actualité pour Webdev{% endblock %}

        {% block menu %}
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ path("accueil") }}">Accueil</a>
            </li>
        </ul>
        {% endblock %}

        {% block contenu %}
        {% if error %}
        <div>{{ error.messageKey|trans(error.messageData, 'security') }}</div>
        {% endif %}

        <form action="{{ path('login') }}" method="post">
        <label for="username">Votre identifiant:</label>
        <input type="text" id="username" name="_username" value="{{ last_username }}" />

        <label for="password">Votre mot de passe:</label>
        <input type="password" id="password" name="_password" />


        <button type="submit">connexion</button>
        </form>
        {% endblock %}

