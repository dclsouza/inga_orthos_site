<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ---- construtores curtos de campo ---- */
function io_t( $label, $default = '', $extra = array() ) {
	return array_merge(
		array(
			'type'    => 'text',
			'label'   => $label,
			'default' => $default,
		),
		$extra
	);
}
function io_ta( $label, $default = '', $rows = 3, $extra = array() ) {
	return array_merge(
		array(
			'type'    => 'textarea',
			'label'   => $label,
			'default' => $default,
			'rows'    => $rows,
		),
		$extra
	);
}
function io_im( $label, $default = '' ) {
	return array(
		'type'    => 'image',
		'label'   => $label,
		'default' => $default,
	);
}
function io_ic( $label, $default = 'star' ) {
	return array(
		'type'    => 'icon',
		'label'   => $label,
		'default' => $default,
	);
}
function io_link( $label, $default = '' ) {
	return io_t( $label, $default, array( 'help' => 'Cole um link completo ou use um atalho: @servicos, @kids, @choque, @equipe, @instalacoes, @quem-somos, @contato, @blog, @english.' ) );
}
function io_unit_sel( $label = 'Unidade' ) {
	return array(
		'type'    => 'select',
		'label'   => $label,
		'options' => io_units(),
	);
}
function io_rep( $label, $item_label, $fields, $default, $add = 'Adicionar item' ) {
	return array(
		'type'       => 'repeater',
		'label'      => $label,
		'item_label' => $item_label,
		'add'        => $add,
		'fields'     => $fields,
		'default'    => $default,
	);
}

/** Modelos de página com campos editáveis: arquivo => função do schema. */
function io_template_schemas() {
	return array(
		'page-templates/template-home.php'        => 'io_schema_home',
		'page-templates/template-quem-somos.php'  => 'io_schema_quem_somos',
		'page-templates/template-equipe.php'      => 'io_schema_equipe',
		'page-templates/template-instalacoes.php' => 'io_schema_instalacoes',
		'page-templates/template-servicos.php'    => 'io_schema_servicos',
		'page-templates/template-kids.php'        => 'io_schema_kids',
		'page-templates/template-choque.php'      => 'io_schema_choque',
		'page-templates/template-contato.php'     => 'io_schema_contato',
		'page-templates/template-english.php'     => 'io_schema_english',
	);
}

function io_schema_for( $template ) {
	$map = io_template_schemas();
	if ( $template && isset( $map[ $template ] ) && function_exists( $map[ $template ] ) ) {
		return call_user_func( $map[ $template ] );
	}
	return array();
}

/* ==========================================================================
   PÁGINA INICIAL
   ========================================================================== */
function io_schema_home() {
	return array(
		'hero'     => array(
			'label'  => 'Destaque inicial',
			'fields' => array(
				'hero_eyebrow' => io_t( 'Texto pequeno acima do título', 'Odontologia especializada' ),
				'hero_title_1' => io_t( 'Título, linha 1', 'Cuidado e tecnologia' ),
				'hero_title_2a' => io_t( 'Título, linha 2 (fina)', 'para' ),
				'hero_title_2b' => io_t( 'Título, linha 2 (em negrito)', 'toda a família.' ),
				'hero_lead'    => io_ta( 'Texto de apoio', 'Na Ingá Orthos, unimos experiência, tecnologia e um atendimento humanizado para transformar sorrisos em todas as fases da vida.' ),
				'hero_cta1'    => io_t( 'Botão principal', 'Agendar consulta' ),
				'hero_cta2'    => io_t( 'Botão WhatsApp', 'Falar no WhatsApp' ),
				'hero_image'   => io_im( 'Foto do destaque', 'theme:hero-equipe.webp' ),
				'trust'        => io_rep(
					'Diferenciais abaixo dos botões',
					'text',
					array(
						'icon' => io_ic( 'Ícone' ),
						'text' => io_ta( 'Texto (use Enter para quebrar a linha)', '', 2 ),
					),
					array(
						array( 'icon' => 'family', 'text' => "Atendimento para\ntoda a família" ),
						array( 'icon' => 'monitor', 'text' => "Tecnologia\nde ponta" ),
						array( 'icon' => 'star', 'text' => "Equipe\nespecializada" ),
						array( 'icon' => 'pin', 'text' => "Ingá, Niterói\nRio de Janeiro" ),
					),
					'Adicionar diferencial'
				),
			),
		),
		'specbar'  => array(
			'label'  => 'Barra verde de especialidades',
			'fields' => array(
				'specbar' => io_rep(
					'Itens da barra',
					'title',
					array(
						'icon'  => io_ic( 'Ícone' ),
						'title' => io_t( 'Título' ),
						'text'  => io_t( 'Frase curta' ),
						'url'   => io_link( 'Link' ),
					),
					array(
						array( 'icon' => 'braces', 'title' => 'Ortodontia', 'text' => 'Aparelhos e alinhadores', 'url' => '@servicos' ),
						array( 'icon' => 'child', 'title' => 'Odontopediatria', 'text' => 'Cuidado para os pequenos', 'url' => '@kids' ),
						array( 'icon' => 'implant', 'title' => 'Implantes', 'text' => 'Soluções modernas para o sorriso', 'url' => '@servicos' ),
						array( 'icon' => 'canal', 'title' => 'Endodontia', 'text' => 'Canal com tecnologia avançada', 'url' => '@servicos' ),
						array( 'icon' => 'gum', 'title' => 'Periodontia', 'text' => 'Saúde da gengiva em primeiro lugar', 'url' => '@servicos' ),
						array( 'icon' => 'bone', 'title' => 'Ortopedia', 'text' => 'Ondas de choque e controle da dor', 'url' => '@choque' ),
					),
					'Adicionar item'
				),
			),
		),
		'units'    => array(
			'label'  => 'Os três espaços de cuidado',
			'fields' => array(
				'units_title' => io_ta( 'Título', "Três espaços de cuidado,\numa só clínica.", 2 ),
				'units_text'  => io_ta( 'Texto', 'Do primeiro dentinho às dores crônicas, a Ingá Orthos reúne odontologia, odontopediatria e ortopedia sob o mesmo princípio: atendimento humano, tecnologia e resultado.' ),
				'units'       => io_rep(
					'Cartões',
					'title',
					array(
						'unit'      => io_unit_sel( 'Unidade (define cores, logo e WhatsApp)' ),
						'image'     => io_im( 'Foto' ),
						'title'     => io_t( 'Título' ),
						'subtitle'  => io_t( 'Subtítulo' ),
						'text'      => io_ta( 'Texto' ),
						'btn_label' => io_t( 'Texto do botão' ),
						'btn_url'   => io_link( 'Link do botão' ),
					),
					array(
						array(
							'unit'      => 'odonto',
							'image'     => 'theme:clinica-recepcao.webp',
							'title'     => 'Ingá Orthos',
							'subtitle'  => 'Odontologia',
							'text'      => 'Ortodontia, Invisalign, implantes, canal, periodontia e mais. Uma equipe especializada, com tecnologia digital, atendendo crianças, adultos e idosos.',
							'btn_label' => 'Ver especialidades',
							'btn_url'   => '@servicos',
						),
						array(
							'unit'      => 'kids',
							'image'     => 'theme:allana-crianca.webp',
							'title'     => 'Icaraí Ortho Kids',
							'subtitle'  => 'Odontologia pediátrica',
							'text'      => 'Clínica especializada em crianças, com atendimento individualizado e uma relação de confiança entre pais, filhos e dentistas.',
							'btn_label' => 'Conhecer a Kids',
							'btn_url'   => '@kids',
						),
						array(
							'unit'      => 'choque',
							'image'     => 'theme:orto-terapia.webp',
							'title'     => 'Terapia de Choque',
							'subtitle'  => 'Ortopedia e medicina da dor',
							'text'      => 'Tratamento não invasivo para dores crônicas, com ondas de choque e medicina regenerativa, realizado por médicos especializados.',
							'btn_label' => 'Ver tratamento',
							'btn_url'   => '@choque',
						),
					),
					'Adicionar cartão'
				),
			),
		),
		'estrutura' => array(
			'label'  => 'Nossa clínica (estrutura)',
			'fields' => array(
				'est_eyebrow'    => io_t( 'Texto pequeno', 'Nossa clínica' ),
				'est_title'      => io_t( 'Título', 'Estrutura completa, pensada em você.' ),
				'est_text'       => io_ta( 'Texto', 'Ambientes modernos, equipamentos de última geração e um atendimento acolhedor para garantir sua segurança, seu conforto e os melhores resultados.' ),
				'est_link_label' => io_t( 'Texto do botão', 'Conhecer a clínica' ),
				'est_cards'      => io_rep(
					'Fotos',
					'caption',
					array(
						'image'   => io_im( 'Foto' ),
						'caption' => io_t( 'Legenda' ),
						'icon'    => io_ic( 'Ícone' ),
					),
					array(
						array( 'image' => 'theme:clinica-recepcao.webp', 'caption' => 'Ambientes acolhedores e modernos', 'icon' => 'star' ),
						array( 'image' => 'theme:scanner.webp', 'caption' => 'Tecnologia e precisão em cada detalhe', 'icon' => 'monitor' ),
						array( 'image' => 'theme:clinica-sala.webp', 'caption' => 'Conforto e segurança para toda a família', 'icon' => 'family' ),
					),
					'Adicionar foto'
				),
			),
		),
		'facts'    => array(
			'label'  => 'Faixa de números',
			'fields' => array(
				'facts' => io_rep(
					'Destaques',
					'title',
					array(
						'title' => io_t( 'Destaque' ),
						'text'  => io_t( 'Legenda' ),
					),
					array(
						array( 'title' => 'Desde 2007', 'text' => 'cuidando de sorrisos no coração do Ingá' ),
						array( 'title' => '08 especialidades', 'text' => 'integradas em uma abordagem multidisciplinar' ),
						array( 'title' => '3 espaços', 'text' => 'Ingá, Icaraí e terapia de ondas de choque' ),
						array( 'title' => 'Todas as idades', 'text' => 'do bebê ao adulto, na mesma clínica' ),
					),
					'Adicionar destaque'
				),
			),
		),
		'team'     => array(
			'label'  => 'Equipe (prévia)',
			'fields' => array(
				'team_title'      => io_t( 'Título', 'Quem cuida de você e da sua família.' ),
				'team_text'       => io_ta( 'Texto', 'Profissionais que atuam há mais de dez anos na região leste fluminense, com formação contínua e um jeito próprio de receber: com escuta, paciência e carinho.' ),
				'team_link_label' => io_t( 'Texto do botão', 'Conhecer a equipe completa' ),
			),
		),
		'quotes'   => array(
			'label'  => 'Depoimentos',
			'fields' => array(
				'quotes_title' => io_t( 'Título', 'O que dizem nossos pacientes.' ),
			),
		),
		'cta'      => array(
			'label'  => 'Chamada final',
			'fields' => array(
				'cta_title' => io_t( 'Título', 'Fácil de chegar, fácil de agendar.' ),
				'cta_text'  => io_ta( 'Texto', 'Escolha a unidade, conte o que você precisa e continuamos a conversa pelo WhatsApp.' ),
				'cta_label' => io_t( 'Texto do botão', 'Agendar consulta' ),
			),
		),
	);
}

/* ==========================================================================
   QUEM SOMOS
   ========================================================================== */
function io_schema_quem_somos() {
	return array(
		'head'     => array(
			'label'  => 'Topo da página',
			'fields' => array(
				'head_lead' => io_ta( 'Frase abaixo do título', 'Uma clínica de excelência para toda a família.', 2 ),
			),
		),
		'historia' => array(
			'label'  => 'Nossa história',
			'fields' => array(
				'intro_title' => io_t( 'Título', 'Uma história que começou no coração do Ingá.' ),
				'intro_text'  => io_ta( 'Texto (linha em branco separa parágrafos)', "A história da nossa clínica começou em 2007, no coração do bairro do Ingá, em Niterói. A fundadora da Ingá Orthos seguiu sua grande paixão pelo atendimento clínico de forma diferenciada.\n\nO princípio de todo o trabalho tem sido proporcionar qualidade nos resultados por meio de técnicas modernas e digitais, transmitindo a melhor experiência no atendimento odontológico.\n\nNossa clínica se tornou referência na região, com alto padrão, conforto, tecnologia, ciência e um corpo clínico altamente qualificado, formado por especialistas.", 9 ),
				'intro_image' => io_im( 'Foto', 'theme:clinica-recepcao.webp' ),
				'timeline'    => io_rep(
					'Linha do tempo',
					'title',
					array(
						'year'  => io_t( 'Ano' ),
						'title' => io_t( 'Título' ),
						'text'  => io_ta( 'Texto' ),
					),
					array(
						array( 'year' => '2007', 'title' => 'Nasce a Ingá Orthos', 'text' => 'A clínica abre as portas no bairro do Ingá, em Niterói, com um atendimento clínico diferenciado.' ),
						array( 'year' => '2011', 'title' => 'Abordagem multidisciplinar', 'text' => 'Os serviços são ampliados, com 08 especialidades e foco em técnicas modernas e digitais.' ),
						array( 'year' => '2023', 'title' => 'Icaraí Ortho Kids', 'text' => 'Chegamos ao bairro vizinho com uma clínica dedicada às crianças, no Shopping Icaraí.' ),
						array( 'year' => 'Hoje', 'title' => 'Odontologia e ortopedia', 'text' => 'Odontologia, odontopediatria e terapia de ondas de choque reunidas sob o mesmo cuidado.' ),
					),
					'Adicionar marco'
				),
			),
		),
		'pilares'  => array(
			'label'  => 'Pilares',
			'fields' => array(
				'pillars_title' => io_t( 'Título', 'O que guia o nosso cuidado.' ),
				'pillars'       => io_rep(
					'Pilares',
					'title',
					array(
						'icon'  => io_ic( 'Ícone' ),
						'title' => io_t( 'Título' ),
						'text'  => io_ta( 'Texto' ),
					),
					array(
						array( 'icon' => 'monitor', 'title' => 'Tecnologia', 'text' => 'Escaneamento digital e equipamentos modernos para diagnósticos precisos e mais conforto.' ),
						array( 'icon' => 'family', 'title' => 'Atendimento humanizado', 'text' => 'Escuta, paciência e carinho em cada consulta, do bebê ao adulto.' ),
						array( 'icon' => 'star', 'title' => 'Equipe especializada', 'text' => 'Dentistas e médicos com formação contínua, atuando juntos no seu tratamento.' ),
					),
					'Adicionar pilar'
				),
			),
		),
	);
}

/* ==========================================================================
   NOSSA EQUIPE
   ========================================================================== */
function io_schema_equipe() {
	return array(
		'head' => array(
			'label'  => 'Topo da página',
			'fields' => array(
				'head_lead'   => io_ta( 'Frase abaixo do título', 'Profissionais que atuam há mais de dez anos na região leste fluminense, com formação contínua e um jeito próprio de receber.', 2 ),
				'note_choque' => io_ta( 'Aviso sobre a Terapia de Choque', 'Na Terapia de Choque, o atendimento é feito exclusivamente por médicos especializados.', 2 ),
			),
		),
	);
}

/* ==========================================================================
   INSTALAÇÕES
   ========================================================================== */
function io_schema_instalacoes() {
	return array(
		'head'    => array(
			'label'  => 'Topo da página',
			'fields' => array(
				'head_lead' => io_ta( 'Frase abaixo do título', 'Ambientes pensados para o seu conforto e a sua segurança. Clique em uma foto para ampliar.', 2 ),
			),
		),
		'galeria' => array(
			'label'  => 'Galeria',
			'fields' => array(
				'gallery' => io_rep(
					'Fotos',
					'caption',
					array(
						'image'   => io_im( 'Foto' ),
						'caption' => io_t( 'Legenda' ),
					),
					array(
						array( 'image' => 'theme:clinica-recepcao.webp', 'caption' => 'Recepção' ),
						array( 'image' => 'theme:clinica-sala.webp', 'caption' => 'Sala de atendimento' ),
						array( 'image' => 'theme:scanner.webp', 'caption' => 'Escaneamento digital' ),
						array( 'image' => 'theme:clinica-consultorio.webp', 'caption' => 'Consultório' ),
						array( 'image' => 'theme:clinica-recepcao-2.webp', 'caption' => 'Atendimento na recepção' ),
						array( 'image' => 'theme:kids-sala.webp', 'caption' => 'Ambiente da Icaraí Ortho Kids' ),
						array( 'image' => 'theme:orto-terapia.webp', 'caption' => 'Sala de terapia de ondas de choque' ),
					),
					'Adicionar foto'
				),
			),
		),
	);
}

/* ==========================================================================
   SERVIÇOS
   ========================================================================== */
function io_schema_servicos() {
	return array(
		'head'     => array(
			'label'  => 'Topo da página',
			'fields' => array(
				'head_lead' => io_ta( 'Frase abaixo do título', 'Especialidades odontológicas para cada fase do sorriso.', 2 ),
			),
		),
		'lista'    => array(
			'label'  => 'Especialidades',
			'fields' => array(
				'serv_title'   => io_t( 'Título', 'Especialidades para cada fase do sorriso.' ),
				'serv_text'    => io_ta( 'Texto', 'Desde 2011 a clínica reúne diferentes especialidades no mesmo endereço. Seu tratamento é planejado por dentistas que conversam entre si, do diagnóstico à manutenção.' ),
				'serv_image'   => io_im( 'Foto lateral', 'theme:scanner.webp' ),
				'serv_caption' => io_t( 'Legenda da foto', 'Escaneamento digital: mais conforto e precisão no planejamento.' ),
				'services'     => io_rep(
					'Especialidades',
					'name',
					array(
						'name' => io_t( 'Nome' ),
						'text' => io_ta( 'Descrição' ),
					),
					array(
						array( 'name' => 'Ortodontia', 'text' => 'Correção da posição dos dentes e dos ossos maxilares, para melhorar a estética do sorriso e a função mastigatória.' ),
						array( 'name' => 'Invisalign', 'text' => 'Alinhador transparente. Tratamento rápido, estético e acessível, conduzido por Invisalign Doctors.' ),
						array( 'name' => 'Odontopediatria', 'text' => 'Saúde bucal de crianças, do nascimento à adolescência, com atendimento também na Icaraí Ortho Kids.' ),
						array( 'name' => 'Implantes', 'text' => 'Tratamento da perda dentária com reabilitações protéticas apoiadas ou retidas por implantes.' ),
						array( 'name' => 'Endodontia (canal)', 'text' => 'Retirada da polpa do dente, o tecido que fica na parte interna da raiz, para tratar dor e infecção.' ),
						array( 'name' => 'Periodontia', 'text' => 'Diagnóstico, prevenção e tratamento das alterações nos tecidos que sustentam os dentes, como a gengiva.' ),
						array( 'name' => 'Bucomaxilofacial', 'text' => 'Especialidade de caráter médico que trata cirurgicamente as doenças da cavidade bucal.' ),
						array( 'name' => 'Prótese e reabilitações orais', 'text' => 'Reposição de dentes e planejamento integrado de casos complexos, devolvendo função e estética.' ),
						array( 'name' => 'Pacientes com necessidades especiais', 'text' => 'Atendimento adaptado e paciente, com experiência em pacientes atípicos e com TEA.' ),
						array( 'name' => 'Harmonização orofacial', 'text' => 'Procedimentos para o equilíbrio e a harmonia entre o rosto e o sorriso.' ),
					),
					'Adicionar especialidade'
				),
			),
		),
		'links'    => array(
			'label'  => 'Outras unidades (rodapé da página)',
			'fields' => array(
				'more_title' => io_t( 'Título', 'Procurando outro cuidado?' ),
				'more_kids'  => io_ta( 'Texto: Ortho Kids', 'Odontologia pediátrica, teste da linguinha e odontologia de bebês.', 2 ),
				'more_choque' => io_ta( 'Texto: Terapia de Choque', 'Ondas de choque, medicina da dor e medicina regenerativa.', 2 ),
			),
		),
	);
}

/* ==========================================================================
   ICARAÍ ORTHO KIDS
   ========================================================================== */
function io_schema_kids() {
	return array(
		'hero'     => array(
			'label'  => 'Destaque inicial',
			'fields' => array(
				'k_eyebrow' => io_t( 'Texto pequeno', 'Odontologia pediátrica' ),
				'k_title'   => io_ta( 'Título', 'Aqui, cuidamos de sorrisos com amor desde os primeiros anos de vida.', 2 ),
				'k_lead'    => io_ta( 'Texto de apoio', 'A Icaraí Ortho Kids é uma clínica especializada no tratamento de crianças, com atendimento odontopediátrico diferenciado e individualizado, que preza pelo relacionamento de confiança entre pais e filhos.' ),
				'k_cta'     => io_t( 'Botão principal', 'Agendar na Ortho Kids' ),
				'k_image'   => io_im( 'Foto do destaque', 'theme:allana-crianca.webp' ),
			),
		),
		'taglines' => array(
			'label'  => 'Frases de carinho',
			'fields' => array(
				'taglines' => io_rep(
					'Frases',
					'text',
					array(
						'text' => io_ta( 'Frase', '', 2 ),
					),
					array(
						array( 'text' => 'Cuidar do sorriso das crianças é plantar saúde e confiança para toda a vida.' ),
						array( 'text' => 'Aqui, cada consulta é feita com paciência, carinho e muita escuta.' ),
						array( 'text' => 'A infância passa rápido, mas um sorriso bem cuidado dura para sempre.' ),
					),
					'Adicionar frase'
				),
			),
		),
		'servicos' => array(
			'label'  => 'Serviços',
			'fields' => array(
				'ks_title' => io_t( 'Título', 'Sorrisos saudáveis começam com pequenos cuidados e grandes doses de amor.' ),
				'ks_text'  => io_ta( 'Texto', 'Mais do que dentes, cuidamos de experiências. Cada atendimento é individualizado e pensado para que a criança se sinta segura e a família, tranquila.' ),
				'kservices' => io_rep(
					'Serviços',
					'title',
					array(
						'icon'  => io_ic( 'Ícone' ),
						'title' => io_t( 'Título' ),
						'text'  => io_ta( 'Descrição' ),
					),
					array(
						array( 'icon' => 'baby', 'title' => 'Odontologia de bebês', 'text' => 'Acompanhamento desde os primeiros dentes, com orientação aos pais.' ),
						array( 'icon' => 'tongue', 'title' => 'Teste da linguinha', 'text' => 'Avaliação do frênulo da língua para identificar dificuldades de mamada, fala e alimentação.' ),
						array( 'icon' => 'braces', 'title' => 'Ortodontia e ortopedia', 'text' => 'Acompanhamento do crescimento dos maxilares e do alinhamento dos dentes.' ),
						array( 'icon' => 'canal', 'title' => 'Canal infantil', 'text' => 'Tratamento endodôntico para crianças de até 12 anos.' ),
					),
					'Adicionar serviço'
				),
			),
		),
		'galeria'  => array(
			'label'  => 'Fotos',
			'fields' => array(
				'k_photo1' => io_im( 'Foto grande', 'theme:kids-renata.webp' ),
				'k_photo2' => io_im( 'Foto pequena', 'theme:kids-sala.webp' ),
				'k_team_title' => io_t( 'Título da equipe', 'Equipe pediátrica' ),
				'k_team_text'  => io_ta( 'Texto da equipe', 'Dentistas especializadas em crianças, que ensinam hábitos de saúde bucal brincando e conquistam a confiança dos pequenos e dos pais.', 2 ),
			),
		),
	);
}

/* ==========================================================================
   TERAPIA DE CHOQUE
   ========================================================================== */
function io_schema_choque() {
	return array(
		'hero'    => array(
			'label'  => 'Destaque inicial',
			'fields' => array(
				'c_eyebrow' => io_t( 'Texto pequeno', 'Ortopedia e medicina da dor' ),
				'c_title'   => io_t( 'Título', 'Terapia de ondas de choque e controle da dor' ),
				'c_sub'     => io_t( 'Frase de destaque', 'Recupere sua qualidade de vida!' ),
				'c_lead'    => io_ta( 'Texto de apoio', 'Tratamento não invasivo para dores crônicas, realizado exclusivamente por médicos especializados.' ),
				'c_cta'     => io_t( 'Botão principal', 'Agendar avaliação' ),
				'c_image'   => io_im( 'Foto do destaque', 'theme:orto-terapia.webp' ),
			),
		),
		'como'    => array(
			'label'  => 'Como funciona',
			'fields' => array(
				'c_how_title' => io_t( 'Título', 'Como a terapia funciona' ),
				'c_how_text'  => io_ta( 'Texto (linha em branco separa parágrafos)', "A Ingá Orthos Ortopedia oferece o tratamento por ondas de choque como indicação nos distúrbios musculoesqueléticos. O tratamento acelera a recuperação e alivia a dor em casos de inflamação: as ondas de choque estimulam o processo de reparação e cicatrização dos tendões, das junções miotendíneas e dos tecidos ósseos.\n\nAs ondas de choque geram microbolhas que eclodem, criando ação analgésica no local lesionado. A resposta total do corpo à terapia leva cerca de 3 a 12 semanas, dependendo do caso, do grau da patologia e da resposta biológica do paciente.", 8 ),
				'c_cond_title' => io_t( 'Título dos quadros tratados', 'Quadros que costumam responder bem' ),
				'c_conditions' => io_ta( 'Quadros tratados (um por linha)', "Tendinite\nFascite plantar\nEsporão do calcâneo\nBursite\nEpicondilite\ne outros", 6 ),
			),
		),
		'areas'   => array(
			'label'  => 'Áreas de atuação',
			'fields' => array(
				'c_areas_title' => io_t( 'Título', 'Áreas de atuação' ),
				'c_areas'       => io_rep(
					'Áreas',
					'title',
					array(
						'icon'  => io_ic( 'Ícone' ),
						'title' => io_t( 'Título' ),
						'items' => io_ta( 'Tratamentos (um por linha)', '', 8 ),
					),
					array(
						array(
							'icon'  => 'wave',
							'title' => 'Medicina da dor',
							'items' => "Terapia de ondas de choque\nBloqueio sacral\nBloqueio sacroilíaco\nBloqueio venoso simpático\nEstimulação transcraniana\nLaserterapia\nMesoterapia\nOzonioterapia\nRadiofrequência\nTermografia\nToxina botulínica na medicina da dor",
						),
						array(
							'icon'  => 'bone',
							'title' => 'Medicina regenerativa tecidual',
							'items' => "Tratamento com células-tronco\nTratamento regenerativo das artroses e tendinopatias\nViscossuplementação com ácido hialurônico\nProloterapia",
						),
						array(
							'icon'  => 'tooth',
							'title' => 'Ortopedia osteometabólica',
							'items' => "Análise da densidade óssea para determinar a osteoporose\nAvaliação diagnóstica das doenças osteometabólicas\nTratamento medicamentoso da osteoporose",
						),
					),
					'Adicionar área'
				),
			),
		),
	);
}

/* ==========================================================================
   CONTATOS
   ========================================================================== */
function io_schema_contato() {
	return array(
		'head' => array(
			'label'  => 'Topo da página',
			'fields' => array(
				'head_lead'  => io_ta( 'Frase abaixo do título', 'Escolha a unidade, conte o que você precisa e continuamos a conversa pelo WhatsApp.', 2 ),
				'form_title' => io_t( 'Título do formulário', 'Agendar consulta' ),
				'form_btn'   => io_t( 'Texto do botão do formulário', 'Continuar no WhatsApp' ),
			),
		),
	);
}

/* ==========================================================================
   ENGLISH
   ========================================================================== */
function io_schema_english() {
	return array(
		'head'  => array(
			'label'  => 'Topo da página',
			'fields' => array(
				'head_lead' => io_ta( 'Subtitle', 'A family clinic for dentistry and orthopedics in Niterói, Brazil.', 2 ),
			),
		),
		'texto' => array(
			'label'  => 'Content',
			'fields' => array(
				'en_title' => io_t( 'Title', 'Care and technology for the whole family.' ),
				'en_text'  => io_ta( 'Text', "Ingá Orthos brings together experience, modern technology and warm, human care to transform smiles at every stage of life.\n\nSince 2007 we have served patients from babies to adults in the Ingá neighborhood of Niterói, Rio de Janeiro.", 6 ),
				'en_units' => io_rep(
					'Our clinics',
					'title',
					array(
						'unit'  => io_unit_sel( 'Clinic' ),
						'title' => io_t( 'Title' ),
						'text'  => io_ta( 'Text' ),
					),
					array(
						array( 'unit' => 'odonto', 'title' => 'Ingá Orthos Dentistry', 'text' => 'Orthodontics, Invisalign, dental implants, endodontics, periodontics, oral surgery and prosthetics, delivered by a team of specialists.' ),
						array( 'unit' => 'kids', 'title' => 'Icaraí Ortho Kids', 'text' => 'A pediatric dental clinic at Shopping Icaraí, with individualized care that builds trust between parents and children.' ),
						array( 'unit' => 'choque', 'title' => 'Shockwave Therapy', 'text' => 'Non-invasive treatment for chronic pain and tendon problems, performed by specialized physicians.' ),
					),
					'Add clinic'
				),
				'en_contact_title' => io_t( 'Contact title', 'Book an appointment' ),
				'en_contact_text'  => io_ta( 'Contact text', 'Send us a message on WhatsApp and we will get back to you.', 2 ),
				'en_contact_btn'   => io_t( 'Button', 'Book on WhatsApp' ),
			),
		),
	);
}
