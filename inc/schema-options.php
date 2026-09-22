<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Telas do menu "Ingá Orthos" no painel.
 * Cada campo tem um valor padrão (o conteúdo original dos sites antigos):
 * o site já nasce completo e o painel só sobrescreve o que for editado.
 */
function io_options_screens() {
	static $screens = null;
	if ( null !== $screens ) {
		return $screens;
	}

	$unit_defaults = array(
		'odonto' => array(
			'name'      => 'Ingá Orthos Odontologia',
			'short'     => 'Ingá, Niterói',
			'topbar'    => 'Estamos no Ingá, em Niterói - RJ',
			'address'   => "R. Dr. Nilo Peçanha, 133, salas 301 a 303\nIngá, Niterói - RJ, 24210-480",
			'wa'        => '5521998105205',
			'wa_label'  => '(21) 99810-5205',
			'wa2'       => '5521998105203',
			'wa2_label' => '(21) 99810-5203',
			'phones'    => '(21) 2712-5206',
			'email'     => 'ingaorthos.odonto@gmail.com',
			'hours'     => '',
			'note'      => '',
			'ig_url'    => 'https://www.instagram.com/ingaorthos/',
			'ig_handle' => '@ingaorthos',
		),
		'kids'   => array(
			'name'      => 'Icaraí Ortho Kids',
			'short'     => 'Shopping Icaraí, Niterói',
			'topbar'    => 'Estamos no Shopping Icaraí, em Niterói - RJ',
			'address'   => "Rua Ator Paulo Gustavo, 229, loja 220\n2º piso do Shopping Icaraí, Niterói - RJ",
			'wa'        => '5521998105209',
			'wa_label'  => '(21) 99810-5209',
			'wa2'       => '',
			'wa2_label' => '',
			'phones'    => '(21) 99810-5206',
			'email'     => 'icaraiorthokids@gmail.com',
			'hours'     => '',
			'note'      => '',
			'ig_url'    => 'https://www.instagram.com/icaraiorthokids',
			'ig_handle' => '@icaraiorthokids',
		),
		'choque' => array(
			'name'      => 'Terapia de Choque',
			'short'     => 'Ingá, Niterói',
			'topbar'    => 'Ingá, Niterói - RJ · Segunda a sexta, das 9h às 18h',
			'address'   => "R. Dr. Nilo Peçanha, 133, sala 303\nIngá, Niterói - RJ, 24210-480",
			'wa'        => '5521995747704',
			'wa_label'  => '(21) 99574-7704',
			'wa2'       => '',
			'wa2_label' => '',
			'phones'    => "(21) 3587-5905\n(21) 2712-5206",
			'email'     => 'ingaorthos.ortopedia@gmail.com',
			'hours'     => 'Segunda a sexta, das 9h às 18h',
			'note'      => 'Aceitamos convênio Petrobras',
			'ig_url'    => 'https://www.instagram.com/ingaorthos_ortopedia',
			'ig_handle' => '@ingaorthos_ortopedia',
		),
	);

	$unit_titles = io_units();

	$contact_sections = array(
		'geral' => array(
			'label'  => 'Links gerais',
			'fields' => array(
				'intranet_url'   => array(
					'type'    => 'text',
					'label'   => 'Link do botão Intranet',
					'default' => 'https://app.simplesdental.com/simples/login',
				),
				'doctoralia_url' => array(
					'type'    => 'text',
					'label'   => 'Link do Doctoralia',
					'default' => 'https://www.doctoralia.com.br/clinicas/inga-orthos-medicina-e-odontologia-premium',
				),
				'facebook_url'   => array(
					'type'    => 'text',
					'label'   => 'Link do Facebook',
					'default' => 'https://www.facebook.com/ingaorthos',
				),
				'maps_query'     => array(
					'type'    => 'text',
					'label'   => 'Endereço do mapa (página Contatos)',
					'help'    => 'Texto usado para localizar o endereço no Google Maps.',
					'default' => 'R. Dr. Nilo Peçanha, 133, Ingá, Niterói - RJ',
				),
			),
		),
	);

	foreach ( $unit_titles as $u => $title ) {
		$d                      = $unit_defaults[ $u ];
		$contact_sections[ $u ] = array(
			'label'  => $title,
			'fields' => array(
				$u . '_name'      => array(
					'type'    => 'text',
					'label'   => 'Nome da unidade',
					'default' => $d['name'],
				),
				$u . '_short'     => array(
					'type'    => 'text',
					'label'   => 'Local (curto, aparece nos cartões)',
					'default' => $d['short'],
				),
				$u . '_topbar'    => array(
					'type'    => 'text',
					'label'   => 'Frase da barra superior',
					'default' => $d['topbar'],
				),
				$u . '_address'   => array(
					'type'    => 'textarea',
					'label'   => 'Endereço (uma linha por linha do endereço)',
					'default' => $d['address'],
				),
				$u . '_wa'        => array(
					'type'    => 'text',
					'label'   => 'WhatsApp (só números, com 55 e DDD)',
					'help'    => 'Exemplo: 5521998105205. Esse número recebe os agendamentos do site.',
					'default' => $d['wa'],
				),
				$u . '_wa_label'  => array(
					'type'    => 'text',
					'label'   => 'WhatsApp (como aparece no site)',
					'default' => $d['wa_label'],
				),
				$u . '_wa2'       => array(
					'type'    => 'text',
					'label'   => 'Segundo WhatsApp (opcional, só números)',
					'default' => $d['wa2'],
				),
				$u . '_wa2_label' => array(
					'type'    => 'text',
					'label'   => 'Segundo WhatsApp (como aparece)',
					'default' => $d['wa2_label'],
				),
				$u . '_phones'    => array(
					'type'    => 'textarea',
					'label'   => 'Telefones fixos (um por linha)',
					'default' => $d['phones'],
				),
				$u . '_email'     => array(
					'type'    => 'text',
					'label'   => 'E-mail',
					'default' => $d['email'],
				),
				$u . '_hours'     => array(
					'type'    => 'text',
					'label'   => 'Horário de funcionamento (opcional)',
					'default' => $d['hours'],
				),
				$u . '_note'      => array(
					'type'    => 'text',
					'label'   => 'Observação (ex.: convênios)',
					'default' => $d['note'],
				),
				$u . '_ig_url'    => array(
					'type'    => 'text',
					'label'   => 'Link do Instagram',
					'default' => $d['ig_url'],
				),
				$u . '_ig_handle' => array(
					'type'    => 'text',
					'label'   => 'Nome do Instagram (@...)',
					'default' => $d['ig_handle'],
				),
			),
		);
	}

	$team_default = array(
		array(
			'name'  => 'Dra. Renata Ramos',
			'role'  => 'Fundadora e CEO. Invisalign Doctor e gestora em saúde.',
			'cro'   => 'CRO RJ 29719',
			'bio'   => 'Fundadora e idealizadora da Ingá Orthos e da Icaraí Ortho Kids. Formada em 2003, pratica a humanização e a fidelização, com dinamismo, amor pela odontologia e fé.',
			'photo' => 'theme:dr-renata.webp',
			'group' => 'both',
		),
		array(
			'name'  => 'Dra. Allana Labruna',
			'role'  => 'Ortodontista e odontopediatra',
			'cro'   => 'CRO RJ 40608',
			'bio'   => 'Graduada em Odontologia pela UFF, pós-graduada em Odontopediatria (INCO) e em Ortodontia, Invisalign Doctor. Ampla experiência no atendimento de pacientes com necessidades especiais e TEA.',
			'photo' => 'theme:dr-allana.webp',
			'group' => 'both',
		),
		array(
			'name'  => 'Dra. Isabella da Mata',
			'role'  => 'Especialista em endodontia e radiologia',
			'cro'   => '',
			'bio'   => '',
			'photo' => 'theme:dr-isabella.webp',
			'group' => 'odonto',
		),
		array(
			'name'  => 'Dra. Suema Nogueira',
			'role'  => 'Clínica geral e especialista em ortodontia',
			'cro'   => '',
			'bio'   => '',
			'photo' => 'theme:dr-suema.webp',
			'group' => 'odonto',
		),
		array(
			'name'  => 'Dra. Gabriela Folly',
			'role'  => 'Odontopediatra',
			'cro'   => 'CRO RJ 51845',
			'bio'   => 'Graduada em Odontologia pela UFF e pós-graduanda em Odontopediatria (INCO). Adora ensinar hábitos de saúde bucal aos pequenos, que costumam confundi-la com uma princesa da Disney.',
			'photo' => '',
			'group' => 'kids',
		),
		array(
			'name'  => 'Dra. Ana Carolina Nascimento',
			'role'  => 'Odontopediatra e endodontista',
			'cro'   => 'CRO RJ 11137',
			'bio'   => 'Graduada pela Pestalozzi, pós-graduada em Odontopediatria (UFF) e em Endodontia (INCO). Responsável pelos tratamentos endodônticos em crianças de até 12 anos.',
			'photo' => '',
			'group' => 'kids',
		),
		array(
			'name'  => 'Dra. Beatriz Rangel',
			'role'  => 'Odontopediatra',
			'cro'   => 'CRO RJ 52760',
			'bio'   => 'Graduada em Odontologia pela UFF e pós-graduanda em Odontopediatria (INCO). Animada, encanta as crianças com carisma e vestimentas da Disney.',
			'photo' => '',
			'group' => 'kids',
		),
		array(
			'name'  => 'Dra. Gabrielle Carrozzino',
			'role'  => 'Odontopediatra',
			'cro'   => 'CRO RJ 43132',
			'bio'   => 'Graduada pela UFF, pós-graduada e mestre em Odontopediatria (UFRJ) e doutoranda na ENSP-FIOCRUZ. Calma, paciente e meiga, conquista a confiança de crianças e pais.',
			'photo' => '',
			'group' => 'kids',
		),
		array(
			'name'  => 'Alessandra Bezerra',
			'role'  => 'Secretária',
			'cro'   => '',
			'bio'   => 'Elo de contato entre pacientes, dentistas e a central de agendamento.',
			'photo' => '',
			'group' => 'kids',
		),
		array(
			'name'  => 'Dr. Euclides',
			'role'  => 'Médico da Terapia de Choque',
			'cro'   => '',
			'bio'   => '',
			'photo' => '',
			'group' => 'choque',
		),
	);

	$screens = array(
		'contatos'     => array(
			'title'    => 'Unidades e contatos',
			'intro'    => 'Endereços, WhatsApp, telefones e redes de cada unidade. Esses dados aparecem no topo, no rodapé, na página Contatos e nos botões de agendamento.',
			'sections' => $contact_sections,
		),
		'equipe'       => array(
			'title'    => 'Equipe',
			'intro'    => 'Profissionais exibidos na Página Inicial, em Nossa Equipe e nas páginas da Ortho Kids e da Terapia de Choque. A ordem daqui é a ordem do site.',
			'sections' => array(
				'equipe' => array(
					'label'  => 'Profissionais',
					'fields' => array(
						'team' => array(
							'type'       => 'repeater',
							'label'      => 'Profissionais',
							'item_label' => 'name',
							'add'        => 'Adicionar profissional',
							'fields'     => array(
								'name'  => array(
									'type'  => 'text',
									'label' => 'Nome',
								),
								'role'  => array(
									'type'  => 'text',
									'label' => 'Função / especialidade',
								),
								'cro'   => array(
									'type'  => 'text',
									'label' => 'CRO / CRM (opcional)',
								),
								'bio'   => array(
									'type'  => 'textarea',
									'label' => 'Mini biografia (opcional)',
								),
								'photo' => array(
									'type'  => 'image',
									'label' => 'Foto (opcional)',
								),
								'group' => array(
									'type'    => 'select',
									'label'   => 'Onde atua',
									'options' => array(
										'odonto' => 'Ingá Orthos Odontologia',
										'kids'   => 'Icaraí Ortho Kids',
										'both'   => 'Ingá Orthos e Icaraí Ortho Kids',
										'choque' => 'Terapia de Choque',
									),
								),
							),
							'default'    => $team_default,
						),
					),
				),
			),
		),
		'depoimentos'  => array(
			'title'    => 'Depoimentos',
			'intro'    => 'Depoimentos de pacientes exibidos na Página Inicial e nas páginas de cada unidade.',
			'sections' => array(
				'depoimentos' => array(
					'label'  => 'Depoimentos',
					'fields' => array(
						'quotes' => array(
							'type'       => 'repeater',
							'label'      => 'Depoimentos',
							'item_label' => 'name',
							'add'        => 'Adicionar depoimento',
							'fields'     => array(
								'quote' => array(
									'type'  => 'textarea',
									'label' => 'Depoimento',
									'rows'  => 4,
								),
								'name'  => array(
									'type'  => 'text',
									'label' => 'Nome do paciente',
								),
								'meta'  => array(
									'type'  => 'text',
									'label' => 'Detalhe (ex.: idade)',
								),
								'unit'  => array(
									'type'    => 'select',
									'label'   => 'Unidade',
									'options' => $unit_titles,
								),
							),
							'default'    => array(
								array(
									'quote' => 'Excelente! Clínica moderna, com tecnologia de ponta e um atendimento primoroso. Todos os profissionais são excelentes e muito capacitados!',
									'name'  => 'Clarissa',
									'meta'  => '32 anos',
									'unit'  => 'odonto',
								),
								array(
									'quote' => 'Excelente equipe, são prestativos, atendimento humanizado, tendo um cuidado admirável pelo paciente. O Dr. Euclides me explicou todo o meu problema e também o tratamento de forma clara, transmitindo total confiança.',
									'name'  => 'Rosiane Santos',
									'meta'  => '',
									'unit'  => 'choque',
								),
							),
						),
					),
				),
			),
		),
		'marca'        => array(
			'title'    => 'Marca e rodapé',
			'intro'    => 'Logotipos usados no cabeçalho e no rodapé de cada aba, e textos do rodapé.',
			'sections' => array(
				'logos'  => array(
					'label'  => 'Logotipos',
					'fields' => array(
						'logo_odonto'       => array(
							'type'    => 'image',
							'label'   => 'Ingá Orthos (cabeçalho, fundo claro)',
							'default' => 'theme:logo-original.png',
						),
						'logo_odonto_light' => array(
							'type'    => 'image',
							'label'   => 'Ingá Orthos (rodapé, fundo escuro)',
							'default' => 'theme:logo-original-claro.png',
						),
						'logo_kids'         => array(
							'type'    => 'image',
							'label'   => 'Icaraí Ortho Kids',
							'default' => 'theme:logo-kids.png',
						),
						'logo_choque'       => array(
							'type'    => 'image',
							'label'   => 'Terapia de Choque',
							'default' => 'theme:logo-terapia.png',
						),
					),
				),
				'rodape' => array(
					'label'  => 'Rodapé',
					'fields' => array(
						'footer_tagline' => array(
							'type'    => 'text',
							'label'   => 'Frase do rodapé',
							'default' => 'Cuidado e tecnologia para toda a família, em Niterói desde 2007.',
						),
						'legal'          => array(
							'type'    => 'text',
							'label'   => 'Dados legais',
							'default' => 'Ingá Orthos – Odontologia e Ortopedia Ltda · CNPJ 06.997.978/0001-56 · EPAO 2314 · RT: Renata R. C. Amaral, CRO RJ 29719',
						),
					),
				),
			),
		),
	);

	return $screens;
}

/** Todas as seções de todas as telas, para procurar padrões. */
function io_options_all_sections() {
	$all = array();
	foreach ( io_options_screens() as $screen ) {
		foreach ( $screen['sections'] as $k => $section ) {
			$all[ $k ] = $section;
		}
	}
	return $all;
}
