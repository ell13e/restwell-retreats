/*
 * Enquire / Contact Page — Restwell Retreats
 * Design: Coastal Calm / Organic Minimalism
 */
import Layout from "@/components/Layout";
import { useState } from "react";
import { toast } from "sonner";

export default function Contact() {
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setSubmitted(true);
    toast.success("Thank you for your enquiry. We will be in touch soon.");
  };

  return (
    <Layout>
      {/* Header */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            Get in touch
          </span>
          <h1 className="text-4xl md:text-5xl mb-6">Ready to rest easy?</h1>
          <p className="text-[#3a5a63] text-lg leading-relaxed">
            Whether you have specific dates in mind or just want to ask about a bathroom measurement, we are here to help. This isn't a booking commitment — it is just the start of a conversation. No pressure, no hard sell.
          </p>
        </div>
      </section>

      {/* Form + Contact Info */}
      <section className="py-16 md:py-24">
        <div className="container max-w-5xl">
          <div className="grid md:grid-cols-5 gap-12">
            {/* Form */}
            <div className="md:col-span-3">
              {submitted ? (
                <div className="bg-white rounded-2xl p-10 shadow-sm text-center">
                  <div className="w-16 h-16 bg-[#A8D5D0]/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span className="text-[#1B4D5C] text-2xl">✓</span>
                  </div>
                  <h2 className="text-2xl mb-4">Thank you for your enquiry</h2>
                  <p className="text-[#3a5a63] leading-relaxed">
                    We have received your message and will get back to you as soon as we can. In the meantime, feel free to explore the rest of the site.
                  </p>
                </div>
              ) : (
                <form onSubmit={handleSubmit} className="bg-white rounded-2xl p-8 md:p-10 shadow-sm space-y-6">
                  <h2 className="text-2xl mb-2">Send us an enquiry</h2>

                  {/* Name */}
                  <div>
                    <label htmlFor="name" className="block text-sm font-medium text-[#1B4D5C] mb-1.5">
                      Your name <span className="text-[#D4A853]">*</span>
                    </label>
                    <input
                      type="text"
                      id="name"
                      name="name"
                      required
                      className="w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30 transition-colors"
                      placeholder="Jane Smith"
                    />
                  </div>

                  {/* Email */}
                  <div>
                    <label htmlFor="email" className="block text-sm font-medium text-[#1B4D5C] mb-1.5">
                      Email address <span className="text-[#D4A853]">*</span>
                    </label>
                    <input
                      type="email"
                      id="email"
                      name="email"
                      required
                      className="w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30 transition-colors"
                      placeholder="jane@example.com"
                    />
                  </div>

                  {/* Phone */}
                  <div>
                    <label htmlFor="phone" className="block text-sm font-medium text-[#1B4D5C] mb-1.5">
                      Phone number (optional)
                    </label>
                    <input
                      type="tel"
                      id="phone"
                      name="phone"
                      className="w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30 transition-colors"
                      placeholder="07700 900000"
                    />
                  </div>

                  {/* Dates */}
                  <div>
                    <label htmlFor="dates" className="block text-sm font-medium text-[#1B4D5C] mb-1.5">
                      Preferred dates (optional)
                    </label>
                    <input
                      type="text"
                      id="dates"
                      name="dates"
                      className="w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30 transition-colors"
                      placeholder="e.g. 15–22 July 2026"
                    />
                  </div>

                  {/* Number of guests */}
                  <div>
                    <label htmlFor="guests" className="block text-sm font-medium text-[#1B4D5C] mb-1.5">
                      Number of guests (optional)
                    </label>
                    <input
                      type="number"
                      id="guests"
                      name="guests"
                      min="1"
                      className="w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30 transition-colors"
                      placeholder="2"
                    />
                  </div>

                  {/* Care requirements */}
                  <div>
                    <label htmlFor="care" className="block text-sm font-medium text-[#1B4D5C] mb-1.5">
                      Care requirements (optional)
                    </label>
                    <textarea
                      id="care"
                      name="care"
                      rows={3}
                      className="w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30 transition-colors resize-y"
                      placeholder="Tell us about any care support you might need, or leave blank if not applicable."
                    />
                  </div>

                  {/* Accessibility needs */}
                  <div>
                    <label htmlFor="accessibility" className="block text-sm font-medium text-[#1B4D5C] mb-1.5">
                      Accessibility needs (optional)
                    </label>
                    <textarea
                      id="accessibility"
                      name="accessibility"
                      rows={3}
                      className="w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30 transition-colors resize-y"
                      placeholder="Any specific accessibility requirements we should know about?"
                    />
                  </div>

                  {/* Message */}
                  <div>
                    <label htmlFor="message" className="block text-sm font-medium text-[#1B4D5C] mb-1.5">
                      Your message <span className="text-[#D4A853]">*</span>
                    </label>
                    <textarea
                      id="message"
                      name="message"
                      required
                      rows={4}
                      className="w-full px-4 py-3 rounded-xl border border-[#E8DFD0] bg-[#F5EDE0]/50 text-[#1B4D5C] text-base focus:border-[#A8D5D0] focus:ring-2 focus:ring-[#A8D5D0]/30 transition-colors resize-y"
                      placeholder="Tell us a bit about what you're looking for, or ask any questions."
                    />
                  </div>

                  <button
                    type="submit"
                    className="w-full bg-[#1B4D5C] text-white font-semibold py-3.5 rounded-full hover:bg-[#164350] transition-colors duration-300 text-base"
                  >
                    Send enquiry
                  </button>
                  <p className="text-xs text-[#8B8B7A] text-center">
                    We will never share your details with third parties.
                  </p>
                </form>
              )}
            </div>

            {/* Contact Info Sidebar */}
            <div className="md:col-span-2 space-y-8">
              <div className="bg-white rounded-2xl p-8 shadow-sm">
                <h3 className="text-xl mb-4">Direct contact</h3>
                <div className="space-y-4 text-[#3a5a63]">
                  <div>
                    <p className="text-sm font-medium text-[#1B4D5C] mb-1">Email</p>
                    <p className="text-[#8B8B7A] italic text-sm">PLACEHOLDER – Email address to be confirmed by client.</p>
                  </div>
                  <div>
                    <p className="text-sm font-medium text-[#1B4D5C] mb-1">Phone</p>
                    <p className="text-[#8B8B7A] italic text-sm">PLACEHOLDER – Phone number to be confirmed by client.</p>
                  </div>
                </div>
              </div>

              <div className="bg-white rounded-2xl p-8 shadow-sm">
                <h3 className="text-xl mb-4">Response time</h3>
                <p className="text-[#3a5a63] leading-relaxed">
                  We aim to respond to all enquiries within <span className="text-[#8B8B7A] italic">PLACEHOLDER – response timeframe to be confirmed by client</span>. If your enquiry is urgent, please call us directly.
                </p>
              </div>

              <div className="bg-[#1B4D5C] rounded-2xl p-8 text-[#F5EDE0]">
                <h3 className="text-xl text-white mb-4">No pressure</h3>
                <p className="text-[#A8D5D0] leading-relaxed">
                  Sending an enquiry is not a booking commitment. It is simply the start of a conversation. We are happy to answer questions, talk through specific needs, or just have a chat about whether Restwell Retreats is right for you.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </Layout>
  );
}
