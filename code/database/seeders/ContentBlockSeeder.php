<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use Illuminate\Database\Seeder;

class ContentBlockSeeder extends Seeder
{
    public function run(): void
    {
        $contentBlocks = [
            // Homepage Header Section
            [
                'key' => 'homepage_hero_title',
                'title_ar' => 'مختبر ليموس - جامعة بومرداس',
                'title_fr' => 'Laboratoire LIMOSE - Université de Boumerdès',
                'title_en' => 'LIMOSE Laboratory - University of Boumerdes',
                'content_ar' => 'مختبر بحثي متطور في جامعة بومرداس يركز على التقنيات الحديثة والابتكار العلمي',
                'content_fr' => 'Laboratoire de recherche avancé à l\'Université de Boumerdès axé sur les technologies modernes et l\'innovation scientifique',
                'content_en' => 'Advanced research laboratory at University of Boumerdes focused on modern technologies and scientific innovation',
                'type' => 'html',
                'page' => 'home',
                'section' => 'hero',
                'order' => 1,
                'is_active' => true
            ],

            // About Section
            [
                'key' => 'about_limose_description',
                'title_ar' => 'حول مختبر ليموس',
                'title_fr' => 'À propos du laboratoire LIMOSE',
                'title_en' => 'About LIMOSE Laboratory',
                'content_ar' => 'مختبر ليموس هو مختبر بحثي رائد في جامعة بومرداس، يتخصص في مجال المعلوماتية والذكاء الاصطناعي وتطوير البرمجيات. يضم المختبر فريقاً من الباحثين المتميزين والطلاب الموهوبين الذين يعملون على مشاريع بحثية مبتكرة تهدف إلى حل المشاكل الحقيقية في المجتمع.',
                'content_fr' => 'Le laboratoire LIMOSE est un laboratoire de recherche de premier plan à l\'Université de Boumerdès, spécialisé dans l\'informatique, l\'intelligence artificielle et le développement logiciel. Le laboratoire rassemble une équipe de chercheurs distingués et d\'étudiants talentueux qui travaillent sur des projets de recherche innovants visant à résoudre des problèmes réels dans la société.',
                'content_en' => 'LIMOSE Laboratory is a leading research laboratory at University of Boumerdes, specializing in computer science, artificial intelligence, and software development. The laboratory brings together a team of distinguished researchers and talented students who work on innovative research projects aimed at solving real problems in society.',
                'type' => 'html',
                'page' => 'about',
                'section' => 'description',
                'order' => 1,
                'is_active' => true
            ],

            // Mission Statement
            [
                'key' => 'limose_mission',
                'title_ar' => 'مهمتنا',
                'title_fr' => 'Notre Mission',
                'title_en' => 'Our Mission',
                'content_ar' => 'نسعى إلى أن نكون مختبراً رائداً في البحث العلمي والتطوير التكنولوجي، ونهدف إلى تقديم حلول مبتكرة للتحديات المعاصرة من خلال البحث المتطور والتعاون مع الشركاء المحليين والدوليين.',
                'content_fr' => 'Nous nous efforçons d\'être un laboratoire leader dans la recherche scientifique et le développement technologique, et nous visons à fournir des solutions innovantes aux défis contemporains grâce à la recherche avancée et à la collaboration avec des partenaires locaux et internationaux.',
                'content_en' => 'We strive to be a leading laboratory in scientific research and technological development, and we aim to provide innovative solutions to contemporary challenges through advanced research and collaboration with local and international partners.',
                'type' => 'html',
                'page' => 'about',
                'section' => 'mission',
                'order' => 2,
                'is_active' => true
            ],

            // Vision Statement
            [
                'key' => 'limose_vision',
                'title_ar' => 'رؤيتنا',
                'title_fr' => 'Notre Vision',
                'title_en' => 'Our Vision',
                'content_ar' => 'أن نكون مركزاً متميزاً للتميز البحثي والابتكار التكنولوجي، يساهم في التنمية المستدامة ويعزز من مكانة الجزائر في المجال العلمي والتكنولوجي على المستوى الإقليمي والدولي.',
                'content_fr' => 'Être un centre d\'excellence distingué pour la recherche et l\'innovation technologique, contribuant au développement durable et renforçant la position de l\'Algérie dans le domaine scientifique et technologique aux niveaux régional et international.',
                'content_en' => 'To be a distinguished center of excellence for research and technological innovation, contributing to sustainable development and enhancing Algeria\'s position in the scientific and technological field at regional and international levels.',
                'type' => 'html',
                'page' => 'about',
                'section' => 'vision',
                'order' => 3,
                'is_active' => true
            ],

            // Research Areas
            [
                'key' => 'research_areas_intro',
                'title_ar' => 'مجالات البحث',
                'title_fr' => 'Domaines de Recherche',
                'title_en' => 'Research Areas',
                'content_ar' => 'يركز مختبر ليموس على عدة مجالات بحثية متطورة تشمل الذكاء الاصطناعي، هندسة البرمجيات، أمن المعلومات، والحوسبة السحابية.',
                'content_fr' => 'Le laboratoire LIMOSE se concentre sur plusieurs domaines de recherche avancés, notamment l\'intelligence artificielle, l\'ingénierie logicielle, la sécurité informatique et l\'informatique en nuage.',
                'content_en' => 'LIMOSE Laboratory focuses on several advanced research areas including artificial intelligence, software engineering, information security, and cloud computing.',
                'type' => 'html',
                'page' => 'research',
                'section' => 'intro',
                'order' => 1,
                'is_active' => true
            ],

            // Contact Information
            [
                'key' => 'contact_address',
                'title_ar' => 'العنوان',
                'title_fr' => 'Adresse',
                'title_en' => 'Address',
                'content_ar' => 'جامعة بومرداس، كلية علوم الحاسوب، مختبر ليموس<br>بومرداس 35000، الجزائر',
                'content_fr' => 'Université de Boumerdès, Faculté d\'Informatique, Laboratoire LIMOSE<br>Boumerdès 35000, Algérie',
                'content_en' => 'University of Boumerdes, Faculty of Computer Science, LIMOSE Laboratory<br>Boumerdes 35000, Algeria',
                'type' => 'html',
                'page' => 'contact',
                'section' => 'address',
                'order' => 1,
                'is_active' => true
            ],

            // Footer Content
            [
                'key' => 'footer_about',
                'title_ar' => 'مختبر ليموس',
                'title_fr' => 'Laboratoire LIMOSE',
                'title_en' => 'LIMOSE Laboratory',
                'content_ar' => 'مختبر بحثي متخصص في علوم الحاسوب والذكاء الاصطناعي بجامعة بومرداس. نعمل على تطوير حلول تكنولوجية مبتكرة لخدمة المجتمع.',
                'content_fr' => 'Laboratoire de recherche spécialisé en informatique et intelligence artificielle à l\'Université de Boumerdès. Nous développons des solutions technologiques innovantes pour servir la société.',
                'content_en' => 'Research laboratory specializing in computer science and artificial intelligence at University of Boumerdes. We develop innovative technological solutions to serve society.',
                'type' => 'html',
                'page' => 'global',
                'section' => 'footer',
                'order' => 1,
                'is_active' => true
            ],

            // News Section
            [
                'key' => 'latest_news_title',
                'title_ar' => 'أحدث الأخبار',
                'title_fr' => 'Dernières Nouvelles',
                'title_en' => 'Latest News',
                'content_ar' => 'تابع آخر الأخبار والأنشطة في مختبر ليموس',
                'content_fr' => 'Suivez les dernières nouvelles et activités du laboratoire LIMOSE',
                'content_en' => 'Follow the latest news and activities from LIMOSE Laboratory',
                'type' => 'html',
                'page' => 'home',
                'section' => 'news',
                'order' => 1,
                'is_active' => true
            ],

            // Services Section
            [
                'key' => 'services_intro',
                'title_ar' => 'خدماتنا',
                'title_fr' => 'Nos Services',
                'title_en' => 'Our Services',
                'content_ar' => 'يقدم مختبر ليموس مجموعة واسعة من الخدمات البحثية والتطويرية للجامعة والمجتمع المحلي والشركات.',
                'content_fr' => 'Le laboratoire LIMOSE offre une large gamme de services de recherche et de développement à l\'université, à la communauté locale et aux entreprises.',
                'content_en' => 'LIMOSE Laboratory offers a wide range of research and development services to the university, local community, and businesses.',
                'type' => 'html',
                'page' => 'services',
                'section' => 'intro',
                'order' => 1,
                'is_active' => true
            ],

            // University Information
            [
                'key' => 'university_info',
                'title_ar' => 'جامعة بومرداس',
                'title_fr' => 'Université de Boumerdès',
                'title_en' => 'University of Boumerdes',
                'content_ar' => 'جامعة محمد بوقرة بومرداس هي جامعة جزائرية رائدة تأسست عام 1998، وتقع في مدينة بومرداس شرق الجزائر العاصمة.',
                'content_fr' => 'L\'Université M\'Hamed Bougara Boumerdès est une université algérienne de premier plan fondée en 1998, située dans la ville de Boumerdès à l\'est d\'Alger.',
                'content_en' => 'M\'Hamed Bougara University of Boumerdes is a leading Algerian university founded in 1998, located in the city of Boumerdes east of Algiers.',
                'type' => 'html',
                'page' => 'about',
                'section' => 'university',
                'order' => 4,
                'is_active' => true
            ]
        ];

        foreach ($contentBlocks as $block) {
            ContentBlock::updateOrCreate(
                ['key' => $block['key']],
                $block
            );
        }
    }
}