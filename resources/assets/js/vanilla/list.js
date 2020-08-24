import Q from 'qoob';
import axios from 'axios';

const module = function module() {
  const lines = Q.find('.js-line');
  const DISTANCE = 800;

  Q.each(lines, line => {
    const parent = Q.parent(line, '.js-line-parent');
    const marker_id = Q.head(Q.data(parent, 'marker'));
    const hammertime = new Hammer.Manager(line);

    hammertime.add(
      new Hammer.Pan({
        threshold: 0,
        direction: Hammer.DIRECTION_HORIZONTAL,
      }),
    );

    hammertime.on('panleft panright', e => {
      Q.addClass(line, 'is-dragging');
      Q.css(line, {
        transform: `translate3d(${Math.min(0, e.deltaX)}px, 0, 0)`,
      });
    });

    hammertime.on('panend', e => {
      if (e.distance > DISTANCE) {
        axios.post('/api/sign-in', {
          marker: marker_id,
        });

        Q.addClass(parent, 'is-active');
        Q.css(line, {
          transform: `translate3d(-3000px, 0, 0) !important`,
          transition: 'all .5s',
        });

        Q.css(parent, {
          transition: 'all .5s',
          height: '0px',
        });

        setTimeout(() => {
          Q.remove(parent);
        }, 500);
      } else {
        Q.removeClass(line, 'is-dragging');
        Q.css(line, {
          transform: `translate3d(0, 0, 0)`,
        });
      }
    });
  });
};

export default module;
