<?php

use Illuminate\Database\Seeder;
use App\Models\Block;

class BlocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    static $blocks = [
    	['category'=> 'Текстовый блок', 'title'=> 'Текст с картинкой', 'fileName'=> '/templates/img_text.html', 'content'=> '{"img": [{"src": "../../templates/images/1.jpg"}], "text": {"text": "Весна начинается капелью, таянием снежных сугробов и сковывающего реки, озера и лужи льда. Какое-то время под пригревающим солнышком еще сохраняются островки грязно-серого снега и дрейфующие по воде льдины. Но скоро и их не станет. Весна войдет в свои права, от зимнего пейзажа не останется и следа. Весна начинается капелью, таянием снежных сугробов и сковывающего реки, озера и лужи льда. Какое-то время под пригревающим солнышком еще сохраняются островки грязно-серого снега и дрейфующие по воде льдины. Но скоро и их не станет. Весна войдет в свои права, от зимнего пейзажа не останется и следа.", "title": "Заголовок"}}','styles'=> '{"title": {"color": "#000000", "font_size": "28", "font_family": "Montserrat", "font_weight": "600", "font_style": "normal", "text_decoration": "none"}, "width": "100", "direction": "row", "main_text": {"color": "#000000", "font_size": "20", "font_family": "Montserrat", "font_weight": "400", "font_style": "normal", "text_decoration": "none"}, "text_align": "left", "bg_color": "#f6f6f7", "padding_top_desktop": "40", "padding_bottom_desktop": "40"}'],
        ['category'=> 'Галерея', 'title'=> 'Простой слайдер', 'fileName'=> '/templates/imgSlider.html', 'content'=> '{"img": [{"src": "../../templates/images/3.jpg", "description": "img0"}, {"src": "../../templates/images/6.jpg", "description": "img1"}, {"src": "../../templates/images/10.jpg", "description": "img2"}, {"src": "../../templates/images/5.jpg", "description": "img3"}, {"src": "../../templates/images/9.jpg", "description": "img4"}]}', 'styles'=> '{"width": "70", "height": "70", "bg_color": "#ffffff", "padding_top_desktop": "40", "padding_bottom_desktop": "40", "slider": {"stagePadding": "80", "margin": "10", "loop": "true", "items": "1", "autoplay": "true", "autoplayTimeout": "3000", "slider_direction": "Под слайдером", "slider_color": "#f6f6f7"}}'],
        
        ['category'=> 'Галерея', 'title'=> 'Галерея', 'fileName'=> '/templates/gallery2.html', 'content'=> '{"img": [{"src": "../../templates/images/3.jpg", "description": "img0"}, {"src": "../../templates/images/6.jpg", "description": "img1"}, {"src": "../../templates/images/10.jpg", "description": "img2"}, {"src": "../../templates/images/5.jpg", "description": "img3"}, {"src": "../../templates/images/9.jpg", "description": "img4"}, {"src": "../../templates/images/3.jpg", "description": "img0"}, {"src": "../../templates/images/6.jpg", "description": "img1"}, {"src": "../../templates/images/10.jpg", "description": "img2"}, {"src": "../../templates/images/5.jpg", "description": "img3"}, {"src": "../../templates/images/3.jpg", "description": "img0"}, {"src": "../../templates/images/6.jpg", "description": "img1"}, {"src": "../../templates/images/10.jpg", "description": "img2"}, {"src": "../../templates/images/5.jpg", "description": "img3"}, {"src": "../../templates/images/3.jpg", "description": "img0"}, {"src": "../../templates/images/6.jpg", "description": "img1"}, {"src": "../../templates/images/10.jpg", "description": "img2"}, {"src": "../../templates/images/5.jpg", "description": "img3"}], "text": {"text": "Изображения с разных уголков мира", "title": "Удивительный и прекрасный мир"}}', 'styles'=> '{"title": {"color": "#000000", "font_size": "28", "font_family": "Montserrat", "font_weight": "600", "font_style": "normal", "text_decoration": "none"}, "width": "100", "main_text": {"color": "#000000", "font_size": "20", "font_family": "Montserrat", "font_weight": "400", "font_style": "normal", "text_decoration": "none"}, "bg_color": "#ffffff", "padding_top_desktop": "40", "padding_bottom_desktop": "40", "gallery": {"distance_between_imgs": "4"}}'],
        ['category'=> ' блок', 'title'=> 'Простой текст', 'fileName'=> '/templates/second.html', 'content'=> '{"text": {"text": "Иногда под космосом понимали только планетную систему, окружающую Солнце. В современном словоупотреблении в связи с этим остался термин \"космогония\", которым обычно обозначают науку о происхождении Солнечной системы, а не всей Вселенной в целом."}}', 'styles'=> '{"width": "70", "main_text": {"color": "#000000", "font_size": "20", "font_family": "Montserrat", "font_weight": "400", "font_style": "normal", "text_decoration": "none"}, "text_align": "center", "bg_color": "#ffffff", "padding_top_desktop": "40", "padding_bottom_desktop": "40"}'],

        ['category'=> 'Обложка', 'title'=> 'Обложка', 'fileName'=> '/templates/first_cover.html', 'content'=> '{"img": [{"src": "../../templates/images/1.jpg"}], "text": {"title": "Заголовок темы", "overhead": "Описание", "subtitle": "Описание 2"}}', 'styles'=> '{"title": {"color": "#000000", "font_size": "80", "font_family": "Montserrat", "font_weight": "500", "font_style": "normal", "text_decoration": "none"}, "height": "100", "overhead": {"color": "#000000", "font_size": "40", "font_family": "Montserrat", "font_weight": "400", "font_style": "normal", "text_decoration": "none", "margin_bottom": "40"}, "subtitle": {"color": "#000000", "font_size": "50", "font_family": "Montserrat", "font_weight": "400", "font_style": "normal", "text_decoration": "none", "margin_top": "32"}, "align_items": "center", "justify_content": "center", "bg_color": "#ffffff", "padding_top_desktop": "40", "padding_bottom_desktop": "40"}'],
        ['category'=> 'Изображение', 'title'=> 'Изображение с описанием', 'fileName'=> '/templates/image.html', 'content'=> '{"img": [{"src": "../../templates/images/3.jpg"}], "text": {"text": "Весна начинается капелью, таянием снежных сугробов и сковывающего реки, озера и лужи льда"}}', 'styles'=> '{"width": "60", "main_text": {"color": "#000000", "font_size": "20", "font_family": "Montserrat", "font_weight": "400", "font_style": "normal", "text_decoration": "none"}, "text_align": "center", "bg_color": "#ffffff", "padding_top_desktop": "40", "padding_bottom_desktop": "40", "align_items": "center"}'],
        
        ['category'=> 'Видео', 'title'=> 'Видео с описанием', 'fileName'=> '/templates/video_text.html', 'content'=> '{"text": {"main_text": "Те, кто начинает новый день со встречи с морем, не могут быть злыми или несчастными. И какое это море — летнее или зимнее, — не имеет значения. Когда видишь, как просыпается солнце, как мягко потягивается вода, жмурясь от первых лучей, понимаешь, что совершенно не важно, на чём спать, что у тебя есть и куда нужно спешить после того, как проснёшься. Главное — дождаться утра, чтобы открыть глаза и обнять взглядом море.", "title": "Эльчин Сафарли (Если бы ты знал)"}, "video": [{"src": "https://www.youtube.com/watch?v=OiLdgNA6hlM&t=19s"}]}', 'styles'=> '{"title": {"color": "#000000", "font_size": "35", "font_family": "Montserrat", "font_weight": "600", "font_style": "normal", "text_decoration": "none"}, "main_text": {"color": "#000000", "font_size": "20", "font_family": "Montserrat", "font_weight": "400", "font_style": "normal", "text_decoration": "none"}, "text_align": "left", "bg_color": "#ffffff", "padding_top_desktop": "40", "padding_bottom_desktop": "40"}'],
        ['category'=> 'Видео', 'title'=> 'Простое видео', 'fileName'=> '/templates/video.html', 'content'=> '{"video": [{"src": "https://www.youtube.com/watch?v=MBPCmjn1rDo"}]}', 'styles'=> '{"width": "70", "height": "50", "bg_color": "#ffffff", "padding_top_desktop": "40", "padding_bottom_desktop": "40"}'],
    	
    ];

    public function run()
    {
        foreach (self::$blocks as $block) {
        	Block::insert([
			    	'category' => $block["category"],
			    	'title' => $block["title"],
			    	'fileName' => $block["fileName"],
			    	'content' => $block["content"], 
			    	'styles' => $block["styles"], 
				]);
            // DB::table('places')->insert([
            //     'name' => $place,
            //     'visited' => rand(0,1) == 1
            // ]);
        }
    }
}




