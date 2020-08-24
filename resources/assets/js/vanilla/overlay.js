import Q from 'qoob';

const module = function module() {
  const admin_container = Q.first('#js-admin-container');
  const overlay = Q.first('#js-overlay');
  const scroller = Q.first('#js-overlay-scroller');
  const triggers = Q.find('.js-overlay-trigger');
  const next_btn = Q.first('#js-overlay-next');
  const back_btn = Q.first('#js-overlay-back');
  const error = Q.first('#js-overlay-error');

  var panel = 0;

  Q.each(triggers, trigger => {
    Q.on(trigger, 'click', e => {
        Q.addClass(admin_container, 'is-locked');
        Q.addClass(overlay, 'is-active');
        Q.addClass('body', 'is-locked');
    
        Q.on(next_btn, 'click', e => {
          if (panel !== 2) {
            e.preventDefault();
    
            panel = panel + 1;
    
            Q.css(scroller, {
              transform: `translate3d(${panel * -100}%, 0, 0)`,
            });
    
            Q.addClass(back_btn, 'is-active');
          }
        });
    
        Q.on(back_btn, 'click', e => {
          if (panel !== 0) {
            e.preventDefault();
    
            panel = panel - 1;
    
            Q.css(scroller, {
              transform: `translate3d(${panel * -100}%, 0, 0)`,
            });
    
            if (panel === 0) {
              Q.removeClass(back_btn, 'is-active');
            }
    
            return;
          }
    
          return window.location.reload();
        });
    
        Q.on(overlay, 'submit', e => {
          e.preventDefault();
    
          const form = e.target;
          const els = {};
          const fields = Array.from(form.elements)
            .filter(el => el.tagName.toLowerCase() === 'input')
            .map(el => el.name)
            .filter(el => {
              return els.hasOwnProperty(el) ? false : (els[el] = true);
            });
    
          const valid =
            fields.includes('names[]') &&
            fields.includes('status') &&
            fields.includes('minutes') &&
            fields.includes('rest-of-day');
    
          if (!valid) {
            Q.addClass(error, 'is-active');
            return Q.on(document, 'click', e => {
              Q.removeClass(error, 'is-active');
            });
          }
    
          Q.addClass(overlay, 'is-finishing');
          form.submit();
        });
      });
  });
};

export default module;
