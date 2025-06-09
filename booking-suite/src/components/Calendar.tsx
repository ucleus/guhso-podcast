'use client';
import { useState } from 'react';
import { Calendar as BigCalendar, momentLocalizer, SlotInfo } from 'react-big-calendar';
import moment from 'moment';
import 'react-big-calendar/lib/css/react-big-calendar.css';

const localizer = momentLocalizer(moment);

export default function Calendar() {
  const [events, setEvents] = useState([]);

  const handleSelectSlot = (slot: SlotInfo) => {
    // TODO integrate booking.create
    alert(`Selected ${slot.start.toString()}`);
  };

  return (
    <BigCalendar
      selectable
      localizer={localizer}
      events={events}
      startAccessor="start"
      endAccessor="end"
      style={{ height: 500 }}
      onSelectSlot={handleSelectSlot}
    />
  );
}
