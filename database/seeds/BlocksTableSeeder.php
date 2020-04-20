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
    	["category"=> "Текстовый блок", "title"=> "Текст с картинкой", "fileName"=> "/templates/img_text.html", "content"=> ["img"=> [["src"=> "../../templates/images/1.jpg"]], "text"=> ["text"=> "Весна начинается капелью, таянием снежных сугробов и сковывающего реки, озера и лужи льда. Какое-то время под пригревающим солнышком еще сохраняются островки грязно-серого снега и дрейфующие по воде льдины. Но скоро и их не станет. Весна войдет в свои права, от зимнего пейзажа не останется и следа. Весна начинается капелью, таянием снежных сугробов и сковывающего реки, озера и лужи льда. Какое-то время под пригревающим солнышком еще сохраняются островки грязно-серого снега и дрейфующие по воде льдины. Но скоро и их не станет. Весна войдет в свои права, от зимнего пейзажа не останется и следа.", "title"=> "Заголовок"]], "styles"=> ["title"=> ["color"=> "#000000", "font_size"=> "2", "font_family"=> "Montserrat"], "width"=> "100", "direction"=> "row", "main_text"=> ["color"=> "#000000", "font_size"=> "1.1", "font_family"=> "Montserrat"], "text_align"=> "left"]],
    	["category"=> "Текстовый блок", "title"=> "Простой текст", "fileName"=> "/templates/second.html", "content"=> ["text"=> ["text"=> "Иногда под космосом понимали только планетную систему, окружающую Солнце. В современном словоупотреблении в связи с этим остался термин 'космогония', которым обычно обозначают науку о происхождении Солнечной системы, а не всей Вселенной в целом."]], "styles"=> ["width"=> "70", "main_text"=> ["color"=> "#000000", "font_size"=> "1.4", "font_family"=> "Montserrat"], "text_align"=> "center"]],
    	["category"=> "Обложка", "title"=> "Обложка", "fileName"=> "/templates/first_cover.html", "content"=> ["img"=> [["src"=> "../../templates/images/1.jpg"]], "text"=> ["title"=> "Заголовок темы", "overhead"=> "Описание", "subtitle"=> "Описание 2"]], "styles"=> ["title"=> ["color"=> "#000000", "font_size"=> "4.5", "font_family"=> "Montserrat"], "height"=> "100", "overhead"=> ["color"=> "#000000", "font_size"=> "1.7", "font_family"=> "Montserrat"], "subtitle"=> ["color"=> "#000000", "font_size"=> "2", "font_family"=> "Montserrat"], "align_items"=> "center", "justify_content"=> "center"]],
    	["category"=> "Изображение", "title"=> "Изображение с описанием", "fileName"=> "/templates/image.html", "content"=> ["img"=> [["src"=> "../../templates/images/3.jpg"]], "text"=> ["text"=> "Весна начинается капелью, таянием снежных сугробов и сковывающего реки, озера и лужи льда"]], "styles"=> ["width"=> "60", "main_text"=> ["color"=> "#000000", "font_size"=> "1", "font_family"=> "Montserrat"], "text_align"=> "center"]],
    	["category"=> "Галерея", "title"=> "Простой слайдер", "fileName"=> "/templates/imgSlider.html", "content"=> ["img"=> [["src"=> "../../templates/images/3.jpg", "description"=> "img0"], ["src"=> "../../templates/images/6.jpg", "description"=> "img1"], ["src"=> "../../templates/images/10.jpg", "description"=> "img2"], ["src"=> "../../templates/images/5.jpg", "description"=> "img3"], ["src"=> "../../templates/images/9.jpg", "description"=> "img4"]]], "styles"=> ["width"=> "70", "height"=> "70"]],
    	["category"=> "Видео", "title"=> "Видео с описанием", "fileName"=> "/templates/video_text.html", "content"=> ["text"=> ["text"=> "Те, кто начинает новый день со встречи с морем, не могут быть злыми или несчастными. И какое это море — летнее или зимнее, — не имеет значения. Когда видишь, как просыпается солнце, как мягко потягивается вода, жмурясь от первых лучей, понимаешь, что совершенно не важно, на чём спать, что у тебя есть и куда нужно спешить после того, как проснёшься. Главное — дождаться утра, чтобы открыть глаза и обнять взглядом море.", "title"=> "Эльчин Сафарли (Если бы ты знал)"], "video"=> [["src"=> "https://www.youtube.com/watch?v=OiLdgNA6hlM&t=19s"]]], "styles"=> ["title"=> ["color"=> "#000000", "font_size"=> "2", "font_family"=> "Montserrat"], "main_text"=> ["color"=> "#000000", "font_size"=> "1.1", "font_family"=> "Montserrat"], "text_align"=> "left"]],
    	["category"=> "Видео", "title"=> "Простое видео", "fileName"=> "/templates/video.html", "content"=> ["video"=> [["src"=> "https://www.youtube.com/watch?v=MBPCmjn1rDo"]]], "styles"=> ["width"=> "70", "justify_content"=> "center"]]
    ];

    public function run()
    {
        foreach (self::$blocks as $block) {
        	Block::insert([
			    	'category' => $block["category"],
			    	'title' => $block["title"],
			    	'fileName' => $block["fileName"],
			    	'content' => json_encode($block["content"]), 
			    	'styles' => json_encode($block["styles"]), 
				]);
            // DB::table('places')->insert([
            //     'name' => $place,
            //     'visited' => rand(0,1) == 1
            // ]);
        }
    }
}
