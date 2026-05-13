import React, { useEffect, useMemo, useRef, useState } from 'react';

const LEFT_NAV = [
  { label: 'Матчі', icon: 'crosshair', active: true },
  { label: 'Сітка', icon: 'bracket' },
  { label: 'Команди', icon: 'users' },
  { label: 'Рейтинг', icon: 'trophy' },
  { label: 'Календар', icon: 'calendar' }
];

const RIGHT_NAV = [
  { label: 'Профіль', icon: 'user' },
  { label: 'Чат', icon: 'chat' },
  { label: 'Квитки', icon: 'ticket' },
  { label: 'Магазин', icon: 'cart' },
  { label: 'Налаштування', icon: 'settings' }
];

const TOP_PLAYERS = [
  {
    rank: '01',
    nick: 'Salam',
    team: 'Skam Mers',
    role: 'AWP',
    rating: '1.42',
    adr: '94.7',
    image:
      'https://cdn2.cameo.com/thumbnails/648e2bf7c2977ff5614bc426-wm-thumbnail.jpg?fit=crop&format=auto&width=210&height=278'
  },
  {
    rank: '02',
    nick: 'Petr',
    team: 'zov',
    role: 'Entry',
    rating: '1.36',
    adr: '91.1',
    image:
      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqiGDWxu58BS_M9_hloRMYzZ_f7LMEs8a6qA&s'
  },
  {
    rank: '03',
    nick: 'S1mpal',
    team: 'baza',
    role: 'Rifle',
    rating: '1.29',
    adr: '86.5',
    image:
      'data:image/jpeg;base64,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'
  },
  {
    rank: '04',
    nick: 'Nuke',
    team: 'triangle',
    role: 'IGL',
    rating: '1.22',
    adr: '80.4',
    image:
      'https://media.tenor.com/cs_6aeE22W4AAAAj/random-guy-ra.gif'
  }
];

const DEFAULT_NEWS_TEXT = `# Новини турнірів
{{photo:1:right}}
## PROLIG відкриває реєстрацію на весняний кубок
**16 команд** зіграють у BO3 форматі за слот у фінальній LAN-сітці.

{{photo:2:left}}
### Деталі
- мапи: Mirage, Inferno, Nuke, Ancient
- чекін команд відкривається о **18:00**
- переможець отримує seed #1 у плей-оф`;

const DEFAULT_NEWS_IMAGES = [
  {
    id: '1',
    name: 'lan-final.jpg',
    size: 42,
    src: 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=720&q=80'
  },
  {
    id: '2',
    name: 'bracket.jpg',
    size: 36,
    src: 'https://images.unsplash.com/photo-1534423861386-85a16f5d13fd?auto=format&fit=crop&w=720&q=80'
  }
];

const PRODUCT_SECTIONS = [
  [
    { name: 'AK-47 Redline', meta: 'Field-Tested', price: '34$', tone: 'red' },
    { name: 'M4A4 Neo-Noir', meta: 'Minimal Wear', price: '58$', tone: 'cyan' },
    { name: 'AWP Asiimov', meta: 'Battle-Scarred', price: '71$', tone: 'amber' }
  ],
  [
    { name: 'USP-S Cortex', meta: 'Factory New', price: '19$', tone: 'cyan' },
    { name: 'Glock Vogue', meta: 'Minimal Wear', price: '14$', tone: 'violet' },
    { name: 'Desert Eagle', meta: 'Code Red', price: '46$', tone: 'red' }
  ],
  [
    { name: 'Kevlar Pass', meta: 'Season ticket', price: '12$', tone: 'green' },
    { name: 'Team Jersey', meta: 'PROLIG 2026', price: '39$', tone: 'amber' },
    { name: 'Mousepad XL', meta: 'Control surface', price: '24$', tone: 'violet' }
  ]
];

function Icon({ name, className = 'icon' }) {
  const paths = {
    bracket: ['M7 4h6v5H7z', 'M7 15h6v5H7z', 'M15 9h2a3 3 0 0 1 3 3v0a3 3 0 0 1-3 3h-2', 'M13 6h2a3 3 0 0 1 3 3v0', 'M13 18h2a3 3 0 0 0 3-3v0'],
    calendar: ['M7 3v4', 'M17 3v4', 'M4 8h16', 'M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1z'],
    cart: ['M6 6h15l-1.5 8h-12L6 6z', 'M6 6 5 3H2', 'M9 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2z', 'M18 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'],
    chat: ['M5 5h14v10H8l-4 4V6a1 1 0 0 1 1-1z', 'M8 9h8', 'M8 12h5'],
    crosshair: ['M12 3v4', 'M12 17v4', 'M3 12h4', 'M17 12h4', 'M8 12a4 4 0 1 0 8 0 4 4 0 0 0-8 0z'],
    edit: ['M12 20h9', 'M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5z'],
    settings: ['M12 15.5A3.5 3.5 0 1 0 12 8a3.5 3.5 0 0 0 0 7.5z', 'M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.6 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 8.92 4.6 1.65 1.65 0 0 0 10 3.09V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82c.25.6.84 1 1.51 1H21a2 2 0 1 1 0 4h-.09c-.67 0-1.26.4-1.51 1z'],
    ticket: ['M4 7h16v4a2 2 0 0 0 0 4v4H4v-4a2 2 0 0 0 0-4z', 'M9 8v8'],
    trophy: ['M8 21h8', 'M12 17v4', 'M7 4h10v6a5 5 0 0 1-10 0V4z', 'M5 5H3v3a4 4 0 0 0 4 4', 'M19 5h2v3a4 4 0 0 1-4 4'],
    user: ['M20 21a8 8 0 0 0-16 0', 'M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10z'],
    users: ['M16 21a6 6 0 0 0-12 0', 'M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z', 'M22 21a5 5 0 0 0-6-4.9', 'M17 3.3a4 4 0 0 1 0 7.4']
  };

  return (
    <svg className={className} viewBox="0 0 24 24" aria-hidden="true">
      {paths[name].map((path) => (
        <path d={path} key={path} />
      ))}
    </svg>
  );
}

function Rail({ side, items, onEditorClick, isEditorOpen }) {
  return (
    <aside className={`rail rail-${side}`} aria-label={`${side} navigation`}>
      <nav className="rail-buttons">
        {items.map((item) => (
          <button
            className={`rail-button ${item.active ? 'active' : ''}`}
            type="button"
            aria-label={item.label}
            title={item.label}
            key={item.label}
          >
            <Icon name={item.icon} />
            <span>{item.label}</span>
          </button>
        ))}
      </nav>
      {side === 'right' ? (
        <div className="editor-launch-panel">
          <button
            className={`editor-launch ${isEditorOpen ? 'active' : ''}`}
            type="button"
            aria-label="Редактор новин"
            title="Редактор новин"
            onClick={onEditorClick}
          >
            <Icon name="edit" />
            <span>Редактор</span>
          </button>
        </div>
      ) : null}
    </aside>
  );
}

function renderInlineMarkdown(text) {
  return text.split(/(\*\*[^*]+\*\*)/g).map((part, index) => {
    if (part.startsWith('**') && part.endsWith('**')) {
      return <strong key={`${part}-${index}`}>{part.slice(2, -2)}</strong>;
    }

    return <React.Fragment key={`${part}-${index}`}>{part}</React.Fragment>;
  });
}

function renderNewsMarkdown(text, images, onRemoveImage) {
  return text
    .split('\n')
    .map((line) => line.trim())
    .map((line, index) => {
      if (!line) {
        return null;
      }

      const imageMatch = line.match(/^\{\{photo:([^}:]+)(?::(left|right|center|full))?\}\}$/);
      if (imageMatch) {
        const [, imageId, align = 'right'] = imageMatch;
        const image = images.find((currentImage) => currentImage.id === imageId);

        if (!image) {
          return <p className="missing-photo" key={index}>photo:{imageId}</p>;
        }

        return (
          <figure
            className={`placed-photo ${align}`}
            key={`${image.id}-${index}`}
            style={{ '--photo-size': `${image.size || 42}%` }}
          >
            <img src={image.src} alt={image.name} />
            <button
              className="image-remove"
              type="button"
              aria-label="Видалити фото"
              onClick={() => onRemoveImage(image.id)}
            >
              ×
            </button>
            <figcaption>{image.name}</figcaption>
          </figure>
        );
      }

      if (line.startsWith('### ')) {
        return <h4 key={index}>{renderInlineMarkdown(line.slice(4))}</h4>;
      }

      if (line.startsWith('## ')) {
        return <h3 key={index}>{renderInlineMarkdown(line.slice(3))}</h3>;
      }

      if (line.startsWith('# ')) {
        return <h2 key={index}>{renderInlineMarkdown(line.slice(2))}</h2>;
      }

      if (line.startsWith('- ')) {
        return (
          <p className="news-bullet" key={index}>
            <span>#</span>
            {renderInlineMarkdown(line.slice(2))}
          </p>
        );
      }

      return <p key={index}>{renderInlineMarkdown(line)}</p>;
    });
}

export default function App() {
  const [shopIndex, setShopIndex] = useState(0);
  const [isShopSliding, setIsShopSliding] = useState(false);
  const [newsText, setNewsText] = useState(DEFAULT_NEWS_TEXT);
  const [newsImages, setNewsImages] = useState(DEFAULT_NEWS_IMAGES);
  const [isEditorOpen, setIsEditorOpen] = useState(false);
  const nextImageId = useRef(3);
  const newsTextareaRef = useRef(null);

  useEffect(() => {
    const timer = window.setInterval(() => {
      setIsShopSliding(true);
    }, 4600);

    return () => window.clearInterval(timer);
  }, []);

  useEffect(() => {
    if (!isShopSliding) {
      return undefined;
    }

    const resetTimer = window.setTimeout(() => {
      setShopIndex((currentIndex) => (currentIndex + 1) % PRODUCT_SECTIONS.length);
      setIsShopSliding(false);
    }, 1000);

    return () => window.clearTimeout(resetTimer);
  }, [isShopSliding]);

  function handleNewsFiles(event) {
    const files = Array.from(event.target.files || []).filter((file) => file.type.startsWith('image/'));

    files.forEach((file) => {
      const reader = new FileReader();
      reader.onload = () => {
        setNewsImages((currentImages) => [
          ...currentImages,
          {
            id: String(nextImageId.current++),
            name: file.name,
            size: 42,
            src: String(reader.result)
          }
        ]);
      };
      reader.readAsDataURL(file);
    });

    event.target.value = '';
  }

  function removeNewsImage(imageId) {
    setNewsImages((currentImages) => currentImages.filter((image) => image.id !== imageId));
  }

  function setNewsImageSize(imageId, nextSize) {
    const normalizedSize = Math.min(100, Math.max(20, Number(nextSize) || 20));

    setNewsImages((currentImages) =>
      currentImages.map((image) => (image.id === imageId ? { ...image, size: normalizedSize } : image))
    );
  }

  function adjustNewsImageSize(imageId, delta) {
    setNewsImages((currentImages) =>
      currentImages.map((image) => {
        if (image.id !== imageId) {
          return image;
        }

        const currentSize = image.size || 42;
        return {
          ...image,
          size: Math.min(100, Math.max(20, currentSize + delta))
        };
      })
    );
  }

  function insertPhotoToken(imageId, align) {
    const cleanToken = `{{photo:${imageId}:${align}}}`;
    const textarea = newsTextareaRef.current;

    setNewsText((currentText) => {
      const markerPattern = new RegExp(`\\n?\\{\\{photo:${imageId}:(?:left|right|center|full)\\}\\}\\n?`, 'g');
      const matches = [...currentText.matchAll(markerPattern)];

      if (matches.length > 0) {
        let didReplaceFirstMarker = false;

        return currentText.replace(markerPattern, (match) => {
          if (didReplaceFirstMarker) {
            return match.startsWith('\n') || match.endsWith('\n') ? '\n' : '';
          }

          didReplaceFirstMarker = true;
          const prefix = match.startsWith('\n') ? '\n' : '';
          const suffix = match.endsWith('\n') ? '\n' : '';
          return `${prefix}${cleanToken}${suffix}`;
        });
      }

      const token = `\n${cleanToken}\n`;

      if (!textarea) {
        return `${currentText}${token}`;
      }

      const start = textarea.selectionStart;
      const end = textarea.selectionEnd;
      return `${currentText.slice(0, start)}${token}${currentText.slice(end)}`;
    });

    window.requestAnimationFrame(() => {
      if (textarea) {
        textarea.focus();
      }
    });
  }

  const newsPreview = useMemo(
    () => renderNewsMarkdown(newsText, newsImages, removeNewsImage),
    [newsText, newsImages]
  );

  const visibleProductSections = [
    PRODUCT_SECTIONS[(shopIndex + 1) % PRODUCT_SECTIONS.length],
    PRODUCT_SECTIONS[shopIndex]
  ];

  return (
    <div className="app-shell">
      <Rail side="left" items={LEFT_NAV} />

      <main className="arena-layout">
        <section className="players-panel" aria-labelledby="top-players-title">
          <div className="players-header">
            <div>
              <h1 id="top-players-title">Топ гравці</h1>
            </div>
          </div>

          <div className="player-grid">
            {TOP_PLAYERS.map((player) => (
              <article className="player-card" key={player.nick}>
                <div className="player-rank">{player.rank}</div>
                <img src={player.image} alt={player.nick} />
                <div className="player-copy">
                  <p>{player.role}</p>
                  <h2>{player.nick}</h2>
                  <span>{player.team}</span>
                </div>
                <div className="stat-row">
                  <strong>{player.rating}</strong>
                  <small>RATING</small>
                  <strong>{player.adr}</strong>
                  <small>ADR</small>
                </div>
              </article>
            ))}
          </div>
        </section>

        <section className="news-panel" aria-labelledby="news-title">
          <div className="news-copy" id="news-title">{newsPreview}</div>
        </section>

        <section className="empty-panel" aria-label="Порожнє поле" />

        <section className="shop-panel" aria-labelledby="shop-title">
          <div className="section-heading">
            <h2 id="shop-title">Товари</h2>
          </div>
          <div className="shop-window">
            <div className={`shop-track ${isShopSliding ? 'sliding' : ''}`}>
              {visibleProductSections.map((section, sectionIndex) => (
                <div className="product-section" key={sectionIndex}>
                  {section.map((product) => (
                    <article className={`product-card ${product.tone}`} key={product.name}>
                      <div className="product-thumb" />
                      <h3>{product.name}</h3>
                      <p>{product.meta}</p>
                      <strong>{product.price}</strong>
                    </article>
                  ))}
                </div>
              ))}
            </div>
          </div>
        </section>
      </main>

      <Rail
        side="right"
        items={RIGHT_NAV}
        isEditorOpen={isEditorOpen}
        onEditorClick={() => setIsEditorOpen((currentValue) => !currentValue)}
      />

      <aside className={`editor-panel ${isEditorOpen ? 'open' : ''}`} aria-hidden={!isEditorOpen}>
        <div className="section-heading">
          <h2>Редактор</h2>
          <span>{'{{photo:id:right}}'}</span>
        </div>
        <textarea
          ref={newsTextareaRef}
          aria-label="Текст новини"
          value={newsText}
          onChange={(event) => setNewsText(event.target.value)}
          spellCheck="false"
          tabIndex={isEditorOpen ? 0 : -1}
        />
        <label className="file-button">
          <input type="file" accept="image/*" multiple onChange={handleNewsFiles} tabIndex={isEditorOpen ? 0 : -1} />
          Додати фото
        </label>
        <div className="editor-thumbs">
          {newsImages.map((image, index) => (
            <figure key={image.id}>
              <div className="editor-image-row">
                <div className="editor-image-preview">
                  <img src={image.src} alt={image.name} />
              <button
                className="image-remove"
                type="button"
                aria-label="Видалити фото"
                onClick={() => removeNewsImage(image.id)}
                tabIndex={isEditorOpen ? 0 : -1}
              >
                ×
              </button>
              <figcaption>Фото {index + 1}</figcaption>
                </div>
                <div className="photo-size-controls" aria-label="Розмір фото">
                  <button type="button" onClick={() => adjustNewsImageSize(image.id, 5)} tabIndex={isEditorOpen ? 0 : -1}>
                    +
                  </button>
                  <input
                    aria-label="Розмір фото у відсотках"
                    type="number"
                    min="20"
                    max="100"
                    value={image.size || 42}
                    onChange={(event) => setNewsImageSize(image.id, event.target.value)}
                    tabIndex={isEditorOpen ? 0 : -1}
                  />
                  <button type="button" onClick={() => adjustNewsImageSize(image.id, -5)} tabIndex={isEditorOpen ? 0 : -1}>
                    -
                  </button>
                </div>
              </div>
              <div className="photo-insert-actions">
                <button type="button" onClick={() => insertPhotoToken(image.id, 'left')} tabIndex={isEditorOpen ? 0 : -1}>
                  L
                </button>
                <button type="button" onClick={() => insertPhotoToken(image.id, 'right')} tabIndex={isEditorOpen ? 0 : -1}>
                  R
                </button>
                <button type="button" onClick={() => insertPhotoToken(image.id, 'center')} tabIndex={isEditorOpen ? 0 : -1}>
                  C
                </button>
                <button type="button" onClick={() => insertPhotoToken(image.id, 'full')} tabIndex={isEditorOpen ? 0 : -1}>
                  F
                </button>
              </div>
            </figure>
          ))}
        </div>
      </aside>
    </div>
  );
}
